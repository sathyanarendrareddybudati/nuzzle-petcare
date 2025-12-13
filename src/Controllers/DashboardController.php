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
        $userId = Session::get('user_id');
        if (!$userId) {
            Session::flash('error', 'You must be logged in to view the dashboard.');
            $this->redirect('/login');
            return;
        }

        $role = Session::get('user_role');
        $petAdModel = new PetAd();

        switch ($role) {
            case "admin":
                $this->redirect('/admin');
                break;
            case "pet_owner":
                $recentAds = $petAdModel->getRecentAdsByUserId($userId);
                $this->render('dashboard/owner', [
                    'pageTitle' => 'Customer Dashboard',
                    'recentAds' => $recentAds
                ]);
                break;
            case "service_provider":
                $this->caretaker();
                break;
            default:
                Session::flash('error', 'Invalid user role.');
                $this->redirect('/');
                break;
        }
    }

    public function caretaker(): void
    {
        Session::start();
        $userId = Session::get('user_id');
        if (!$userId || Session::get('user_role') !== 'service_provider') {
            Session::flash('error', 'You do not have permission to access this page.');
            $this->redirect('/login');
            return;
        }

        $petAdModel = new PetAd();
        $recentAds = $petAdModel->getRecentAds(); // Or a more specific method for providers

        $profileModel = new CaretakerProfile();
        $profile = $profileModel->getProfileByUserId($userId);

        $this->render('dashboard/caretaker', [
            'pageTitle' => 'Service Provider Dashboard',
            'recentAds' => $recentAds,
            'profile' => $profile
        ]);
    }
}
