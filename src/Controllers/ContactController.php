<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Contact;
use App\Core\EmailService;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/index', ['pageTitle' => 'Contact Us']);
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            if (
                empty($name) ||
                empty($email) ||
                empty($subject) ||
                empty($message) ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
            ) {
                Session::flash('error', 'Please fill in all fields correctly.');
                $this->redirect('/contact');
                return;
            }

            $contactModel = new Contact();
            $contactModel->create([
                'name'    => $name,
                'email'   => $email,
                'subject' => $subject,
                'message' => $message,
            ]);

            $to = $_ENV['SMTP_USERNAME'];

            $emailBody  = "<h2>New Contact Form Submission</h2>";
            $emailBody .= "<p><strong>Name:</strong> {$name}</p>";
            $emailBody .= "<p><strong>Email:</strong> {$email}</p>";
            $emailBody .= "<p><strong>Subject:</strong> {$subject}</p>";
            $emailBody .= "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>";

            $emailService = new EmailService();
            $emailSent = $emailService->sendEmail($to, $subject, $emailBody);

            if ($emailSent) {
                Session::flash('success', 'Thanks for contacting us! We will get back to you soon.');
            } else {
                Session::flash('error', 'There was an error sending your message. Please try again later.');
            }

            $this->redirect('/contact');
        }

        $this->redirect('/contact');
    }
}