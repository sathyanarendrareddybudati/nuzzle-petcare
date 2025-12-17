<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\CaretakerProfile;

class CaretakerProfileController extends Controller
{
    public function create(): void
    {
        Session::start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $profileModel = new CaretakerProfile();
        $profile = $profileModel->getProfileByUserId($userId);

        $this->render('caretaker/create-profile', [
            'pageTitle' => 'My Caretaker Profile',
            'profile' => $profile,
        ]);
    }

    public function store(): void
    {
        Session::start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $availability = trim($_POST['availability'] ?? '');

        $errors = [];
        if (empty($title)) $errors[] = 'A profile title is required (e.g., \'Experienced Dog Walker\').';

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect('/caretaker/profile');
            return;
        }

        $profileModel = new CaretakerProfile();
        $profileModel->createOrUpdate([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'availability' => $availability,
        ]);

        Session::flash('success', 'Your profile has been updated successfully!');
        $this->redirect('/dashboard/caretaker');
    }
}
