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
        $this->render('my-pets/create', [
            'pageTitle' => 'Add a New Pet'
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/my-pets');
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
            $storageService = new FirebaseStorageService();
            try {
                $data['image_url'] = $storageService->uploadImage($file['tmp_name'], $file['name']);
            } catch (\Exception $e) {
                Session::flash('error', 'Failed to upload image to cloud storage: ' . $e->getMessage());
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
            if ($data['image_url']) {
                try {
                    $storageService = new FirebaseStorageService();
                    $storageService->deleteFileByUrl($data['image_url']);
                } catch (\Exception $e) {
                    error_log('Failed to delete orphaned Firebase Storage file: ' . $data['image_url']);
                }
            }
            Session::flash('error', 'Failed to add pet.');
            $this->redirect('/my-pets/create');
        }
    }

    public function edit($id): void
    {
        $petModel = new Pet();
        $pet = $petModel->find((int)$id);

        if (!$pet || $pet['user_id'] !== Session::get('user')['id']) {
            Session::flash('error', 'Pet not found or you do not have permission to edit it.');
            $this->redirect('/my-pets');
            return;
        }

        $this->render('my-pets/edit', [
            'pageTitle' => 'Edit Pet: ' . htmlspecialchars($pet['name']),
            'pet' => $pet,
        ]);
    }

    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/my-pets');
            return;
        }

        $petModel = new Pet();
        $pet = $petModel->find((int)$id);

        if (!$pet || $pet['user_id'] !== Session::get('user')['id']) {
            Session::flash('error', 'Pet not found or you do not have permission to update it.');
            $this->redirect('/my-pets');
            return;
        }

        $data = [
            'name' => trim($_POST['name']),
            'category_id' => $_POST['category_id'],
            'breed' => trim($_POST['breed']),
            'age_years' => $_POST['age_years'] ? (int)$_POST['age_years'] : null,
            'age_months' => $_POST['age_months'] ? (int)$_POST['age_months'] : null,
            'gender' => $_POST['gender'],
            'description' => trim($_POST['description']),
        ];

        if (empty($data['name']) || empty($data['category_id']) || empty($data['gender'])) {
            Session::flash('error', 'Pet name, category, and gender are required.');
            $this->redirect("/my-pets/{$id}/edit");
            return;
        }

        $newImageUrl = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image'];
            $storageService = new FirebaseStorageService();
            try {
                $newImageUrl = $storageService->uploadImage($file['tmp_name'], $file['name']);
                $data['image_url'] = $newImageUrl;
            } catch (\Exception $e) {
                Session::flash('error', 'Failed to upload new image: ' . $e->getMessage());
                $this->redirect("/my-pets/{$id}/edit");
                return;
            }
        }

        if ($petModel->update((int)$id, $data)) {
            if ($newImageUrl && $pet['image_url']) {
                try {
                    $storageService = new FirebaseStorageService();
                    $storageService->deleteFileByUrl($pet['image_url']);
                } catch (\Exception $e) {
                    error_log('Failed to delete old Firebase Storage file: ' . $pet['image_url']);
                }
            }
            Session::flash('success', 'Pet updated successfully!');
            $this->redirect('/my-pets');
        } else {
            if ($newImageUrl) {
                try {
                    $storageService = new FirebaseStorageService();
                    $storageService->deleteFileByUrl($newImageUrl);
                } catch (\Exception $e) {
                    error_log('Failed to delete orphaned new Firebase Storage file: ' . $newImageUrl);
                }
            }
            Session::flash('error', 'Failed to update pet.');
            $this->redirect("/my-pets/{$id}/edit");
        }
    }

    public function destroy($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/my-pets');
            return;
        }

        $petModel = new Pet();
        $pet = $petModel->find((int)$id);

        if (!$pet || $pet['user_id'] !== Session::get('user')['id']) {
            Session::flash('error', 'Pet not found or you do not have permission to delete it.');
            $this->redirect('/my-pets');
            return;
        }

        if ($pet['image_url']) {
            try {
                $storageService = new FirebaseStorageService();
                $storageService->deleteFileByUrl($pet['image_url']);
            } catch (\Exception $e) {
                error_log('Failed to delete Firebase Storage file: ' . $pet['image_url'] . ' - ' . $e->getMessage());
            }
        }

        if ($petModel->delete((int)$id)) {
            Session::flash('success', 'Pet deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete pet.');
        }
        $this->redirect('/my-pets');
    }
}
