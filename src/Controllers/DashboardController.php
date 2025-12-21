<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\PetAd;
use App\Models\CaretakerProfile;

class DashboardController extends Controller
{
    public function index(): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            Session::flash('error', 'You must be logged in to view the dashboard.');
            $this->redirect('/login');
            return;
        }

        $userId = $user['id'];
        $role = $user['role'] ?? '';
        
        $normalizedRole = strtolower(trim(preg_replace('/[\s_-]+/', '_', $role)));

        switch ($normalizedRole) {
            case "admin":
                $this->redirect('/admin');
                break;
            case "pet_owner":
                $this->redirect('/my-pets');
                break;
            case "service_provider":
                $this->caretaker();
                break;
            default:
                Session::flash('error', 'Invalid user role. Detected role: ' . $role);
                $this->redirect('/');
                break;
        }
    }

    public function caretaker(): void
    {
        Session::start();
        $user = Session::get('user');
        $role = $user['role'] ?? '';
        $normalizedRole = strtolower(trim(preg_replace('/[\s_-]+/', '_', $role)));

        if (!$user || $normalizedRole !== 'service_provider') {
            Session::flash('error', 'You do not have permission to access this page.');
            $this->redirect('/login');
            return;
        }

        $userId = $user['id'];
        $petAdModel = new PetAd();
        $recentAds = $petAdModel->getRecentAds(); 

        $profileModel = new CaretakerProfile();
        $profile = $profileModel->getProfileByUserId($userId);

        $this->render('dashboard/caretaker', [
            'pageTitle' => 'Service Provider Dashboard',
            'recentAds' => $recentAds,
            'profile' => $profile
        ]);
    }
}
