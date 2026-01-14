<?php

namespace App\Controllers;

use App\Core\Controller;

class PrivacyPolicyController extends Controller
{
    public function index(): void
    {
        $this->render('privacy-policy/index', [
            'pageTitle' => 'Privacy Policy',
        ]);
    }
}