<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Pet;
use App\Models\PetAd;
use App\Services\FirebaseStorageService;

class MyPetsController extends Controller
{
    public function index(): void
    {
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $userId = Session::get('user')['id'];
        
        $petModel = new Pet();
        $pets = $petModel->getPetsByUserId($userId);

        $petAdModel = new PetAd();
        $ads = $petAdModel->getAdsByUserId($userId);

        $this->render('my-pets/index', [
            'pageTitle' => 'My Pet Dashboard',
            'pets' => $pets,
            'ads' => $ads,
        ]);
    }

    public function create(): void
    {
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $this->render('my-pets/create', [
            'pageTitle' => 'Add a New Pet'
        ]);
    }

    public function store(): void
    {
        Session::start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $userId = Session::get('user')['id'];
        $data = [
            'user_id' => $userId,
            'name' => trim($_POST['name']),
            'category_id' => $_POST['category_id'],
            'breed' => trim($_POST['breed']),
            'age_years' => $_POST['age_years'] ? (int)$_POST['age_years'] : null,
            'age_months' => $_POST['age_months'] ? (int)$_POST['age_months'] : null,
            'gender' => $_POST['gender'],
            'description' => trim($_POST['description']),
            'image_url' => null,
        ];

        if (empty($data['name']) || empty($data['category_id']) || empty($data['gender'])) {
            Session::flash('error', 'Pet name, category, and gender are required.');
            $this->redirect('/my-pets/create');
            return;
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image'];
            $uploadDir = 'uploads/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = uniqid() . '-' . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $storageService = new FirebaseStorageService();
                try {
                    $data['image_url'] = $storageService->uploadFile($filePath, "pet_images/{$fileName}");
                    unlink($filePath); 
                } catch (\Exception $e) {
                    Session::flash('error', 'Failed to upload image to cloud storage: ' . $e->getMessage());
                    $this->redirect('/my-pets/create');
                    return;
                }
            } else {
                Session::flash('error', 'Failed to move uploaded file.');
                $this->redirect('/my-pets/create');
                return;
            }
        }

        $petModel = new Pet();
        $petId = $petModel->create($data);

        if ($petId) {
            Session::flash('success', 'Pet added successfully!');
            $this->redirect('/my-pets');
        } else {
            Session::flash('error', 'Failed to add pet.');
            if ($data['image_url']) {
                try {
                    $storageService = new FirebaseStorageService();
                    $storageService->deleteFileByUrl($data['image_url']);
                } catch (\Exception $e) {
                    error_log('Failed to delete orphaned Firebase Storage file: ' . $data['image_url']);
                }
            }
            $this->redirect('/my-pets/create');
        }
    }
}
