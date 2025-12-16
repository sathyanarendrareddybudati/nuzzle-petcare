<?php
namespace App\Controllers;

use App\Core\Controller;

class AboutUsController extends Controller {
    public function index(): void
    {
        $this->render('aboutus/aboutus', [
            'pageTitle' => 'About Us - Nuzzle PetCare'
        ]);
    }
}