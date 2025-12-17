<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;
use App\Models\Role;

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
            $this->redirect('/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->verifyCredentials($email, $password);

        if ($user) {
            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role_name']
            ]);

            Session::flash('success', 'Welcome back, ' . e($user['name']) . '!');
            $this->redirect('/dashboard');
        } else {
            Session::flash('error', 'Invalid email or password.');
            $this->redirect('/login');
        }
    }

    public function showRegister(): void
    {
        $roleModel = new Role();
        $roles = $roleModel->getAllRoles();
        $this->render('auth/register', ['pageTitle' => 'Create Account', 'roles' => $roles]);
    }

    public function register(): void
    {
        Session::start();
        $name = trim($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role_id = $_POST['role_id'] ?? '';

        $errors = [];
        if (empty($name)) $errors[] = 'Name is required.';
        if (empty($email)) $errors[] = 'A valid email is required.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters long.';

        $roleModel = new Role();
        $roles = $roleModel->getAllRoles();
        $role_ids = array_column($roles, 'id');
        if (!in_array($role_id, $role_ids)) $errors[] = 'Please select a valid role.';

        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $errors[] = 'An account with this email already exists.';
        }

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect('/register');
            return;
        }

        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id,
        ]);

        if ($userId) {
            $user = $userModel->findById($userId);
            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role_name']
            ]);

            Session::flash('success', 'Account created successfully! Welcome!');
            $this->redirect('/dashboard');
        } else {
            Session::flash('error', 'There was a problem creating your account.');
            $this->redirect('/register');
        }
    }

    public function showAdminRegisterForm(): void
    {
        $this->render('auth/register_admin', ['pageTitle' => 'Admin Registration']);
    }

    public function registerAdmin(): void
    {
        Session::start();
        $name = trim($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role_id = 1; // Admin role ID

        $errors = [];
        if (empty($name)) $errors[] = 'Name is required.';
        if (empty($email)) $errors[] = 'A valid email is required.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters long.';

        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $errors[] = 'An account with this email already exists.';
        }

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            $this->redirect('/register/admin');
            return;
        }

        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id,
        ]);

        if ($userId) {
            Session::flash('success', 'Admin account created successfully!');
            $this->redirect('/login');
        } else {
            Session::flash('error', 'There was a problem creating the admin account.');
            $this->redirect('/register/admin');
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
            $this->redirect('/forgot-password');
            return;
        }

        $userModel = new User();
        if (!$userModel->emailExists($email)) {
            Session::flash('success', 'If an account with that email exists, a password reset link has been sent.');
            $this->redirect('/forgot-password');
            return;
        }

        Session::flash('success', 'If an account with that email exists, a password reset link has been sent.');
        $this->redirect('/forgot-password');
    }


    public function logout(): void
    {
        Session::start();
        Session::destroy();
        $this->redirect('/');
    }
}
