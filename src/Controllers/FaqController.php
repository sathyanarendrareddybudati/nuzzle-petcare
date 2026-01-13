<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqModel = new Faq();
        $faqs = $faqModel->findAll();

        $this->render('faq/index', [
            'faqs' => $faqs
        ]);
    }

    public function adminIndex()
    {
        $faqModel = new Faq();
        $faqs = $faqModel->findAll();

        $this->render('faq/admin_index', [
            'faqs' => $faqs
        ]);
    }

    public function create()
    {
        $this->render('faq/create');
    }

    public function store()
    {
        $faqModel = new Faq();
        $faqModel->create([
            'question' => $_POST['question'],
            'answer' => $_POST['answer']
        ]);

        header('Location: /admin/faq');
    }

    public function edit($id)
    {
        $faqModel = new Faq();
        $faq = $faqModel->find($id);

        $this->render('faq/edit', [
            'faq' => $faq
        ]);
    }

    public function update($id)
    {
        $faqModel = new Faq();
        $faqModel->update($id, [
            'question' => $_POST['question'],
            'answer' => $_POST['answer']
        ]);

        header('Location: /admin/faq');
    }

    public function destroy($id)
    {
        $faqModel = new Faq();
        $faqModel->delete($id);

        header('Location: /admin/faq');
    }
}
