<?php
namespace App\Middleware;

use App\Core\Session;

class AdminMiddleware
{
    public function handle(): void
    {
        Session::start();
        if (Session::get('user')['role'] !== 'admin') {
            Session::flash('error', 'You are not authorized to access this page.');
            header('Location: /login');
            exit();
        }
    }
}
