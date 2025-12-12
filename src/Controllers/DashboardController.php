<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Session::get('user_id')) {
            Session::flash('error', 'You must be logged in to view the dashboard.');
            redirect('/login');
        }
    }

    public function index(): void
    {
        $role = Session::get('user_role');

        switch ($role) {
            case 'admin':
                redirect('/admin');
                break;
            case 'owner':
                $this->render('dashboard/owner', ['pageTitle' => 'Owner Dashboard']);
                break;
            case 'caretaker':
                $this->render('dashboard/caretaker', ['pageTitle' => 'Caretaker Dashboard']);
                break;
            default:
                Session::flash('error', 'Invalid user role.');
                redirect('/');
                break;
        }
    }
}
