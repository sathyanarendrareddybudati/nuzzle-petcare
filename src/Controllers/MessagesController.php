<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Message;
use App\Models\User;

class MessagesController extends Controller
{
    public function create(int $recipientId): void
    {
        Session::start();
        $sender = Session::get('user');
        
        if (!$sender) {
            Session::flash('error', 'You must be logged in to send messages.');
            $this->redirect('/login');
            return;
        }

        if ($sender['id'] == $recipientId) {
            Session::flash('error', 'You cannot send a message to yourself.');
            $this->redirect('/');
            return;
        }

        $userModel = new User();
        $recipient = $userModel->find($recipientId);

        if (!$recipient) {
            Session::flash('error', 'User not found.');
            $this->redirect('/');
            return;
        }

        $this->render('messages/create', [
            'pageTitle' => 'Send Message',
            'recipient' => $recipient,
            'sender' => $sender
        ]);
    }

    public function store(): void
    {
        Session::start();
        $sender = Session::get('user');
        
        if (!$sender) {
            Session::flash('error', 'You must be logged in to send messages.');
            $this->redirect('/login');
            return;
        }

        $recipientId = (int)($_POST['recipient_id'] ?? 0);
        $subject = trim($_POST['subject'] ?? '');
        $bodyContent = trim($_POST['message'] ?? '');

        if ($sender['id'] == $recipientId) {
            Session::flash('error', 'You cannot send a message to yourself.');
            $this->redirect('/');
            return;
        }

        $errors = [];
        if (empty($subject)) $errors[] = 'Subject is required.';
        if (empty($bodyContent)) $errors[] = 'Message is required.';

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect("/messages/create/$recipientId");
            return;
        }

        $messageModel = new Message();
        $success = $messageModel->create([
            'sender_user_id' => $sender['id'],
            'recipient_user_id' => $recipientId,
            'subject' => $subject,
            'body_content' => $bodyContent,
        ]);

        if ($success) {
            Session::flash('success', 'Message sent successfully!');
            $this->redirect('/messages');
        } else {
            Session::flash('error', 'Failed to send message.');
            $this->redirect("/messages/create/$recipientId");
        }
    }

    public function index(): void
    {
        Session::start();
        $user = Session::get('user');
        
        if (!$user) {
            Session::flash('error', 'You must be logged in to view messages.');
            $this->redirect('/login');
            return;
        }

        $messageModel = new Message();
        $conversations = $messageModel->getConversations($user['id']);

        $this->render('messages/index', [
            'pageTitle' => 'Messages',
            'conversations' => $conversations
        ]);
    }

    public function show(int $participantId): void
    {
        Session::start();
        $user = Session::get('user');
        
        if (!$user) {
            Session::flash('error', 'You must be logged in to view messages.');
            $this->redirect('/login');
            return;
        }

        if ($user['id'] == $participantId) {
            Session::flash('error', 'You cannot view a conversation with yourself.');
            $this->redirect('/messages');
            return;
        }

        $messageModel = new Message();
        $messages = $messageModel->getMessages($user['id'], $participantId);

        $userModel = new User();
        $participant = $userModel->find($participantId);

        if (!$participant) {
            Session::flash('error', 'User not found.');
            $this->redirect('/messages');
            return;
        }

        $this->render('messages/show', [
            'pageTitle' => 'Conversation with ' . $participant['name'],
            'messages' => $messages,
            'participant' => $participant,
            'currentUser' => $user
        ]);
    }
}
