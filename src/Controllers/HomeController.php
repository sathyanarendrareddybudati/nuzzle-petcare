<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', ['pageTitle' => 'NUZZLE PetCare - Find Your Perfect Pet']);
    }
}
