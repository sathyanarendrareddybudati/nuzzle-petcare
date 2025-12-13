<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class DashboardController extends Controller
{
    public function index(): void
    {
        if (!Session::get('user_id')) {
            Session::flash('error', 'You must be logged in to view the dashboard.');
            $this->redirect('/login');
            return;
        }

        $role = Session::get('user_role');

        switch ($role) {
            case "admin":
                $this->redirect('/admin');
                break;
            case "pet_owner":
                $this->render('dashboard/owner', ['pageTitle' => 'Customer Dashboard']);
                break;
            case "service_provider":
                $this->render('dashboard/caretaker', ['pageTitle' => 'Service Provider Dashboard']);
                break;
            default:
                Session::flash('error', 'Invalid user role.');
                $this->redirect('/');
                break;
        }
    }
}
