<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\PetAd;
use App\Models\Service;
use App\Models\Location;

class PetAdController extends Controller
{
    public function index(): void
    {
        Session::start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $petAdModel = new PetAd();
        $ads = $petAdModel->getAdsByUserId($userId);

        $this->render('pet-ads/my-ads', [
            'pageTitle' => 'My Ads',
            'ads' => $ads,
        ]);
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/my-ads');
            return;
        }

        $petAdModel = new PetAd();
        $ad = $petAdModel->getAdById((int)$id);

        if (!$ad) {
            $this->redirect('/my-ads');
            return;
        }

        $this->render('pet-ads/ad-details', [
            'pageTitle' => $ad['title'],
            'ad' => $ad,
        ]);
    }

    public function create(): void
    {
        $serviceModel = new Service();
        $locationModel = new Location();

        $services = $serviceModel->getAllServices();
        $locations = $locationModel->getAllLocations();

        $this->render('pet-ads/create-ad', [
            'pageTitle' => 'Create Ad',
            'services' => $services,
            'locations' => $locations,
        ]);
    }

    public function store(): void
    {
        Session::start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $service_id = $_POST['service_id'] ?? '';
        $location_id = $_POST['location_id'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $cost = $_POST['cost'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';

        $errors = [];
        if (empty($title)) $errors[] = 'Title is required.';
        if (empty($service_id)) $errors[] = 'Service is required.';
        if (empty($location_id)) $errors[] = 'Location is required.';
        if (empty($cost)) $errors[] = 'Cost is required.';
        if (empty($start_date)) $errors[] = 'Start date is required.';
        if (empty($end_date)) $errors[] = 'End date is required.';

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect('/my-ads/create');
            return;
        }

        $petAdModel = new PetAd();
        $adId = $petAdModel->create([
            'user_id' => $userId,
            'title' => $title,
            'service_id' => $service_id,
            'location_id' => $location_id,
            'description' => $description,
            'cost' => $cost,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        if ($adId) {
            Session::flash('success', 'Ad created successfully!');
            $this->redirect('/my-ads');
        } else {
            Session::flash('error', 'There was a problem creating your ad.');
            $this->redirect('/my-ads/create');
        }
    }
}
