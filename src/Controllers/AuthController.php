<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->render('auth/login', ['pageTitle' => 'Login']);
    }

    public function login(): void
    {
        Session::start();
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Session::flash('error', 'Please enter both email and password.');
            redirect('/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->verifyCredentials($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role']; // Set user role

            Session::flash('success', 'Welcome back, ' . e($user['name']) . '!');
            redirect('/dashboard');
        } else {
            Session::flash('error', 'Invalid email or password.');
            redirect('/login');
        }
    }

    public function showRegister(): void
    {
        $this->render('auth/register', ['pageTitle' => 'Create Account']);
    }

    public function register(): void
    {
        Session::start();
        $name = trim($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? ''; // owner or caretaker

        $errors = [];
        if (empty($name)) $errors[] = 'Name is required.';
        if (empty($email)) $errors[] = 'A valid email is required.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters long.';
        if (!in_array($role, ['owner', 'caretaker'])) $errors[] = 'Please select a valid role.';

        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $errors[] = 'An account with this email already exists.';
        }

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            redirect('/register');
            return;
        }

        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);

        if ($userId) {
            $user = $userModel->getById($userId);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            Session::flash('success', 'Account created successfully! Welcome!');
            redirect('/dashboard');
        } else {
            Session::flash('error', 'There was a problem creating your account.');
            redirect('/register');
        }
    }
    
    public function showForgotPasswordForm(): void
    {
        $this->render('auth/forgot-password', ['pageTitle' => 'Forgot Password']);
    }

    public function handleForgotPasswordRequest(): void
    {
        Session::start();
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

        if (empty($email)) {
            Session::flash('error', 'Please enter your email address.');
            redirect('/forgot-password');
            return;
        }

        $userModel = new User();
        if (!$userModel->emailExists($email)) {
            Session::flash('success', 'If an account with that email exists, a password reset link has been sent.');
            redirect('/forgot-password');
            return;
        }

        // In a real application, you would generate a secure token, save it to the database with an expiry date,
        // and send an email with a link containing the token.
        // For this example, we'll just show a success message.

        Session::flash('success', 'If an account with that email exists, a password reset link has been sent.');
        redirect('/forgot-password');
    }


    public function logout(): void
    {
        Session::start();
        session_unset();
        session_destroy();
        redirect('/');
    }
}
