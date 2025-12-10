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

        $errors = [];
        if (!$email) $errors[] = 'Please enter a valid email.';
        if ($password === '') $errors[] = 'Please enter your password.';

        if ($errors) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect('/login');
        }

        $user = (new User())->verifyCredentials($email, $password);
        if (!$user) {
            Session::flash('error', 'Invalid email or password.');
            $this->redirect('/login');
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        $redirect = $_SESSION['redirect_after_login'] ?? '/';
        unset($_SESSION['redirect_after_login']);

        Session::flash('success', 'You have been logged in successfully!');
        $this->redirect($redirect);
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
        $confirm = $_POST['confirm_password'] ?? '';
        $roleId = (int)($_POST['role_id'] ?? 0);
        $phone = trim($_POST['phone'] ?? '');

        $errors = [];
        if ($name === '') $errors[] = 'Please enter your name.';
        if (!$email) $errors[] = 'Please enter a valid email.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
        if ($password !== $confirm) $errors[] = 'Passwords do not match.';
        if (!in_array($roleId, [2,3], true)) $errors[] = 'Please select a valid role.';

        $model = new User();
        if ($email && $model->emailExists($email)) {
            $errors[] = 'An account with this email already exists.';
        }

        if ($errors) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect('/register');
        }

        $userId = $model->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'role_id' => $roleId,
        ]);

        $user = $model->getById($userId);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        Session::flash('success', 'Your account has been created successfully!');
        $this->redirect('/');
    }

    public function logout(): void
    {
        Session::start();
        session_destroy();
        $this->redirect('/');
    }
}
