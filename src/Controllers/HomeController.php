<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Pet;

class HomeController extends Controller
{
    public function index(): void
    {
        $petModel = new Pet();
        $pets = $petModel->getAll(); // Or a method like getFeaturedPets()

        $this->render('home/index', [
            'pageTitle' => 'NUZZLE PetCare - Find Your Perfect Pet',
            'pets' => $pets
        ]);
    }
}
