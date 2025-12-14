<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index(): void
    {
        Session::start();
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

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
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

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
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $recipientId = $_POST['recipient_id'] ?? null;
        $body = trim($_POST['body'] ?? '');
        $subject = trim($_POST['subject'] ?? 'New Message');

        if (!$recipientId || empty($body)) {
            Session::flash('error', 'Message could not be sent.');
            $this->redirect('/messages/chat?participant_id=' . $recipientId);
            return;
        }

        $messageModel = new Message();
        $messageModel->create([
            'sender_user_id' => $userId,
            'recipient_user_id' => $recipientId,
            'subject' => $subject,
            'body_content' => $body,
        ]);

        // Here you would typically send an email as well.
        // For this example, we'll just redirect back to the chat.

        $this->redirect('/messages/chat?participant_id=' . $recipientId);
    }
}
