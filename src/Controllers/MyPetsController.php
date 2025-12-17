<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Pet;
use App\Models\PetAd;

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
}
