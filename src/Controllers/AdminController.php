<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\PetAd;

class AdminController extends Controller
{
    public function index(): void
    {
        $this->render('admin/index', ['pageTitle' => 'Admin Dashboard']);
    }

    public function users(): void
    {
        $userModel = new User();
        $users = $userModel->getAllUsersWithRoles();

        $this->render('admin/users', [
            'pageTitle' => 'Manage Users',
            'users' => $users
        ]);
    }

    public function ads(): void
    {
        $petAdModel = new PetAd();
        $ads = $petAdModel->findAll(); // You might want to create a more detailed method in your model

        $this->render('admin/ads', [
            'pageTitle' => 'Manage Pet Ads',
            'ads' => $ads
        ]);
    }
}
