<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PetAd;

class PetAdsController extends Controller
{
    public function index(): void
    {
        $filters = [
            'location' => $_GET['location'] ?? null,
            'pet_type' => $_GET['pet_type'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
        ];

        $petAdModel = new PetAd();
        $ads = $petAdModel->findAllWithFilters($filters);

        $this->render('pet-ads/index', [
            'ads' => $ads,
            'pageTitle' => 'Browse Pet Ads',
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
