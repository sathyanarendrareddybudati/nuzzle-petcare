<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CaretakerProfile;
use App\Models\Location;
use App\Models\PetAd;
use App\Models\Service;

class HomeController extends Controller
{
    public function index(): void
    {
        $petAdModel = new PetAd();
        $featuredAds = $petAdModel->findAllWithFilters([]);

        $serviceModel = new Service();
        $services = $serviceModel->all();

        $locationModel = new Location();
        $locations = $locationModel->all();

        $caretakerModel = new CaretakerProfile();
        $featuredCaretakers = $caretakerModel->getFeaturedProfiles();

        $this->render('home/index', [
            'pageTitle' => 'Nuzzle - Find the Perfect Care for Your Pet',
            'ads' => array_slice($featuredAds, 0, 3),
            'services' => $services,
            'locations' => $locations,
            'caretakers' => $featuredCaretakers,
        ]);
    }
}
