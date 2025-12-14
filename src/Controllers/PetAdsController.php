<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PetAd;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Location;
use App\Core\Session;

class PetAdsController extends Controller
{
    public function index(): void
    {
        $filters = [
            'species' => $_GET['species'] ?? '',
            'gender' => $_GET['gender'] ?? '',
            'q' => $_GET['q'] ?? '',
            'sort' => $_GET['sort'] ?? 'newest',
        ];

        $petAdModel = new PetAd();
        $pets = $petAdModel->findAllWithFilters($filters);

        $this->render('pet-ads/index', [
            'pets' => $pets,
            'pageTitle' => 'Browse Pets',
            'filters' => $filters,
        ]);
    }

    public function show($id): void
    {
        $id = (int)$id;
        $petAdModel = new PetAd();
        $ad = $petAdModel->getAdById($id);
        if (!$ad) {
            $this->redirect('/pets');
        }

        $this->render('pet-ads/show', ['ad' => $ad, 'pageTitle' => $ad['title']]);
    }

    public function create(): void
    {
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $petModel = new Pet();
        $serviceModel = new Service();
        $locationModel = new Location();

        $userId = Session::get('user')['id'];
        // The following line assumes a getPetsByUserId method exists in your Pet model
        $pets = $petModel->getPetsByUserId($userId); 
        $services = $serviceModel->all();
        $locations = $locationModel->all();

        $this->render('pet-ads/create', [
            'pageTitle' => 'Post a New Pet Ad',
            'pets' => $pets,
            'services' => $services,
            'locations' => $locations,
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $data = [
            'user_id' => Session::get('user')['id'],
            'pet_id' => $_POST['pet_id'],
            'service_id' => $_POST['service_id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'location_id' => $_POST['location_id'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'ad_type' => $_POST['ad_type'],
            'status' => 'active',
        ];

        if (empty($data['title']) || empty($data['description']) || empty($data['price'])) {
            // In a real application, you would re-render the form with error messages
            $this->redirect('/pets/create');
            return;
        }

        $petAdModel = new PetAd();
        $adId = $petAdModel->create($data);

        if ($adId) {
            $this->redirect('/pets/' . $adId);
        } else {
            // Handle failure, perhaps with an error message
            $this->redirect('/pets/create');
        }
    }
}
