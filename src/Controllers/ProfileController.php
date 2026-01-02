<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(): void
    {
        Session::start();
        $user = Session::get('user');

        if (!$user) {
            Session::flash('error', 'You must be logged in to view your profile.');
            $this->redirect('/login');
            return;
        }

        $this->render('profile/index', [
            'pageTitle' => 'My Profile',
            'user' => $user
        ]);
    }

    public function update(): void
    {
        Session::start();
        $userSession = Session::get('user');

        if (!$userSession) {
            Session::flash('error', 'You must be logged in to update your profile.');
            $this->redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);

            if (empty($name) || empty($email)) {
                Session::flash('error', 'Name and email cannot be empty.');
                $this->redirect('/profile');
                return;
            }

            $userModel = new User();
            $success = $userModel->update($userSession['id'], [
                'name' => $name,
                'email' => $email
            ]);

            if ($success) {
                // Update session data
                $userSession['name'] = $name;
                $userSession['email'] = $email;
                Session::set('user', $userSession);

                Session::flash('success', 'Profile updated successfully.');
            } else {
                Session::flash('error', 'Failed to update profile.');
            }

            $this->redirect('/profile');
        } else {
            $this->redirect('/profile');
        }
    }
}
