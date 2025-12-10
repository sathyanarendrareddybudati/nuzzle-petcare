<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/index', ['pageTitle' => 'Contact Us']);
    }

    public function submit(): void
    {
        Session::flash('success', 'Thanks for contacting us! We will get back to you soon.');
        $this->redirect('/contact');
    }
}
