<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Message;
use App\Models\User;
use App\Core\EmailService;

class MessageController extends Controller
{
    public function index(): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $userId = $user['id'];
        $messageModel = new Message();
        $conversations = $messageModel->getConversations($userId);

        $this->render('messages/index', [
            'pageTitle' => 'My Messages',
            'conversations' => $conversations,
        ]);
    }

    public function chat(): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $userId = $user['id'];
        $participantId = $_GET['participant_id'] ?? null;
        if (!$participantId) {
            $this->redirect('/messages');
            return;
        }

        $messageModel = new Message();
        $messages = $messageModel->getMessages($userId, (int)$participantId);

        $userModel = new User();
        $participant = $userModel->findById((int)$participantId);

        $this->render('messages/chat', [
            'pageTitle' => 'Chat with ' . e($participant['name']),
            'messages' => $messages,
            'participant' => $participant,
        ]);
    }

    public function send(): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $userId = $user['id'];
        $recipientId = $_POST['recipient_id'] ?? null;
        $body = trim($_POST['body'] ?? '');
        $subject = trim($_POST['subject'] ?? 'New Message');

        if (!$recipientId || empty($body)) {
            Session::flash('error', 'Message could not be sent.');
            $this->redirect("/messages/chat?participant_id={$recipientId}");
            return;
        }

        $messageModel = new Message();
        $messageModel->create([
            'sender_user_id' => $userId,
            'recipient_user_id' => $recipientId,
            'subject' => $subject,
            'body_content' => $body,
        ]);

        // Send email notification
        $userModel = new User();
        $recipient = $userModel->findById((int)$recipientId);
        $sender = $userModel->findById($userId);

        if ($recipient && $sender) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $siteUrl = $protocol . $host;

            $emailService = new EmailService();
            $emailBody = $emailService->renderTemplate(__DIR__ . '/../../views/emails/new_message.php', [
                'recipientName' => $recipient['name'],
                'senderName' => $sender['name'],
                'messageContent' => $body,
                'loginLink' => $siteUrl . '/login'
            ]);

            $emailService->sendEmail($recipient['email'], 'You have a new message from ' . $sender['name'], $emailBody);
        }

        $this->redirect("/messages/chat?participant_id={$recipientId}");
    }
}
