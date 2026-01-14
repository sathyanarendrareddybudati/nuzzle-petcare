<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PetAd;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Location;
use App\Core\Session;
use App\Models\PetCategory;

class PetAdsController extends Controller
{
    public function index(): void
    {
        $petAdModel = new PetAd();
        $serviceModel = new Service();
        $locationModel = new Location();
        $categoryModel = new PetCategory();

        $filters = [
            'q' => $_GET['q'] ?? null,
            'service' => $_GET['service'] ?? null,
            'location' => $_GET['location'] ?? null,
            'species' => $_GET['species'] ?? null,
            'breed' => $_GET['breed'] ?? null,
            'gender' => $_GET['gender'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
        ];

        $ads = $petAdModel->findAllWithFilters($filters);
        $services = $serviceModel->all();
        $locations = $locationModel->all();
        $species = $categoryModel->all();

        $this->render('pet-ads/index', [
            'pageTitle' => 'Find Pet Care Services',
            'ads' => $ads,
            'services' => $services,
            'locations' => $locations,
            'species' => $species,
            'filters' => $filters,
        ]);
    }

    public function create(): void
    {
        Session::start();
        $user = Session::get('user');

        if (!$user) {
            Session::flash('error', 'You must be logged in to create an ad.');
            $this->redirect('/login');
            return;
        }

        $petModel = new Pet();
        $pets = $petModel->getPetsByUserId($user['id']);
        
        $serviceModel = new Service();
        $services = $serviceModel->all();

        $locationModel = new Location();
        $locations = $locationModel->all();

        $categoryModel = new PetCategory();
        $categories = $categoryModel->all();

        $this->render('pet-ads/create', [
            'pageTitle' => 'Post a New Pet Ad',
            'pets' => $pets,
            'services' => $services,
            'locations' => $locations,
            'categories' => $categories
        ]);
    }

    public function store(): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            Session::flash('error', 'Authentication required.');
            $this->redirect('/login');
            return;
        }

        $data = [
            'user_id' => $user['id'],
            'ad_type' => $_POST['ad_type'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'pet_id' => $_POST['pet_id'] ?? null,
            'service_id' => $_POST['service_id'] ?? null,
            'price' => $_POST['price'],
            'location_id' => $_POST['location_id'],
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'status' => 'open' 
        ];

        $petAdModel = new PetAd();
        $adId = $petAdModel->create($data);

        if ($adId) {
            Session::flash('success', 'Pet ad created successfully!');
            $this->redirect('/pet-ads');
        } else {
            Session::flash('error', 'Failed to create ad.');
            $this->redirect('/pet-ads/create');
        }
    }

    public function show(int $id): void
    {
        $petAdModel = new PetAd();
        $ad = $petAdModel->getAdById($id);

        if (!$ad) {
            http_response_code(404);
            $this->render('errors/404', ['pageTitle' => 'Ad Not Found']);
            return;
        }

        $this->render('pet-ads/show', [
            'pageTitle' => $ad['title'],
            'ad' => $ad
        ]);
    }

    public function edit(int $id): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            Session::flash('error', 'You must be logged in to edit an ad.');
            $this->redirect('/login');
            return;
        }

        $petAdModel = new PetAd();
        $ad = $petAdModel->getAdById($id);

        if (!$ad) {
            $this->error(404, 'Ad not found.');
            return;
        }

        if ((int)$ad['user_id'] !== (int)$user['id']) {
            Session::flash('error', 'You are not authorized to edit this ad.');
            $this->redirect('/pets/' . $id);
            return;
        }

        $petModel = new Pet();
        $pets = $petModel->getPetsByUserId($user['id']);

        $serviceModel = new Service();
        $services = $serviceModel->all();

        $locationModel = new Location();
        $locations = $locationModel->all();

        $categoryModel = new PetCategory();
        $categories = $categoryModel->all();

        $this->render('pet-ads/edit', [
            'pageTitle' => 'Edit Pet Ad',
            'ad' => $ad,
            'pets' => $pets,
            'services' => $services,
            'locations' => $locations,
            'categories' => $categories
        ]);
    }

    public function update(int $id): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            Session::flash('error', 'Authentication required.');
            $this->redirect('/login');
            return;
        }

        $petAdModel = new PetAd();
        $ad = $petAdModel->getAdById($id);

        if (!$ad || (int)$ad['user_id'] !== (int)$user['id']) {
            Session::flash('error', 'You are not authorized to perform this action.');
            $this->redirect('/');
            return;
        }

        $data = [
            'ad_type' => $_POST['ad_type'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'pet_id' => $_POST['pet_id'] ?? null,
            'service_id' => $_POST['service_id'] ?? null,
            'price' => $_POST['price'],
            'location_id' => $_POST['location_id'],
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
        ];

        if ($petAdModel->update($id, $data)) {
            Session::flash('success', 'Ad updated successfully.');
            $this->redirect('/pets/' . $id);
        } else {
            Session::flash('error', 'Failed to update ad.');
            $this->redirect('/pets/' . $id . '/edit');
        }
    }
}
