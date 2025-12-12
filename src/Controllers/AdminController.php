<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // This is a basic security check. In a real application, you would have a more robust role-based access control system.
        if (Session::get('user_role') !== 'admin') {
            Session::flash('error', 'You are not authorized to access this page.');
            redirect('/');
        }
    }

    public function index(): void
    {
        $this->render('admin/index', ['pageTitle' => 'Admin Dashboard']);
    }

    // Add methods for user, pet, and content management here.
}
