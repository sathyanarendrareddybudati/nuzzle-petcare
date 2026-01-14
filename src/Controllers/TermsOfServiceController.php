<?php

namespace App\Controllers;

use App\Core\Controller;

class TermsOfServiceController extends Controller
{
    public function index(): void
    {
        $this->render('terms-of-service/index', [
            'pageTitle' => 'Terms of Service',
        ]);
    }
}