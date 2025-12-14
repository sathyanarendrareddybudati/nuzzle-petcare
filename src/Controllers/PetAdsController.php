<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PetAd;

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
}
