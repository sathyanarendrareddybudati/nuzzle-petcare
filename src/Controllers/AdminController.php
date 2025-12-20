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
        $ads = $petAdModel->all();

        $this->render('admin/ads', [
            'pageTitle' => 'Manage Pet Ads',
            'ads' => $ads
        ]);
    }

    public function editUser(int $userId): void
    {
        $userModel = new User();
        $user = $userModel->find($userId);

        if (!$user) {
            $this->error(404, 'User not found');
            return;
        }

        $this->render('admin/edit_user', [
            'pageTitle' => 'Edit User',
            'user' => $user
        ]);
    }

    public function updateUser(int $userId): void
    {
        $userModel = new User();
        $user = $userModel->find($userId);

        if (!$user) {
            $this->error(404, 'User not found');
            return;
        }

        $name = $_POST['name'] ?? $user['name'];
        $email = $_POST['email'] ?? $user['email'];
        $role = $_POST['role'] ?? $user['role'];

        $userModel->update($userId, [
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        $this->redirect('/admin/users');
    }

    public function deleteUser(int $userId): void
    {
        $userModel = new User();
        $userModel->delete($userId);
        $this->redirect('/admin/users');
    }

    public function content(): void
    {
        $this->render('admin/content', ['pageTitle' => 'Manage Content']);
    }
}
