<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Pet;

class MyPetsController extends Controller
{
    public function index(): void
    {
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $petModel = new Pet();
        $userId = Session::get('user')['id'];
        $pets = $petModel->getPetsByUserId($userId);

        $this->render('my-pets/index', [
            'pageTitle' => 'My Pets',
            'pets' => $pets,
        ]);
    }
}
