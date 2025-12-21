<?php

namespace App\Middleware;

use App\Core\Session;

class PetOwnerMiddleware implements MiddlewareInterface
{
    public function handle(): void
    {
        if (!Session::isAuthenticated() || Session::getUserRole() !== 'pet_owner') {
            Session::flash('error', 'You must be logged in as a pet owner to access this page.');
            header('Location: /login');
            exit;
        }
    }
}
