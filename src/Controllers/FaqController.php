<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(): void
    {
        $faqModel = new Faq();
        $faqs = $faqModel->getAllFaqs();

        $this->render('faq/index', [
            'pageTitle' => 'Frequently Asked Questions',
            'faqs' => $faqs,
        ]);
    }
}
