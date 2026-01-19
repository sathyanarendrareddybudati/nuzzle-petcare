<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\EmailService;
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
            $roleModel = new Role();
            $roleName = $roleModel->getRoleNameById($user['role_id']);

            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $roleName
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

        if (!in_array($role_id, $role_ids)) {
            $errors[] = 'Invalid user role.';
        }


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
            $roleName = $roleModel->getRoleNameById($user['role_id']);
            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $roleName
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
        $user = $userModel->getUserByEmail($email);

        // Always show same message for security (prevents email enumeration)
        Session::flash('success', 'If an account with that email exists, a password reset link has been sent.');

        if (!$user) {
            // Email doesn't exist - still redirect without sending email
            $this->redirect('/forgot-password');
            return;
        }

        // Email exists - generate reset token and send email
        $token = $userModel->generatePasswordResetToken($email);
        $resetLink = $_ENV['APP_URL'] . '/reset-password?email=' . urlencode($email) . '&token=' . urlencode($token);

        $emailService = new EmailService();
        $subject = 'Password Reset Request - Nuzzle PetCare';
        $body = $this->getPasswordResetEmailBody($user['name'], $resetLink);

        if ($emailService->sendEmail($user['email'], $subject, $body)) {
            error_log("Password reset email sent to: {$user['email']}");
        } else {
            error_log("Failed to send password reset email to: {$user['email']}");
        }

        $this->redirect('/forgot-password');
    }

    private function getPasswordResetEmailBody(string $userName, string $resetLink): string
    {
        return "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { max-width: 600px; margin: 0 auto; }
                    .header { background-color: #f5f5f5; padding: 20px; text-align: center; }
                    .content { padding: 20px; }
                    .button { 
                        display: inline-block; 
                        background-color: #007bff; 
                        color: white; 
                        padding: 10px 20px; 
                        text-decoration: none; 
                        border-radius: 5px; 
                        margin: 20px 0;
                    }
                    .footer { background-color: #f5f5f5; padding: 15px; text-align: center; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Password Reset Request</h2>
                    </div>
                    <div class='content'>
                        <p>Hello {$userName},</p>
                        <p>We received a request to reset your password. Click the button below to create a new password:</p>
                        <p><a href='{$resetLink}' class='button'>Reset Password</a></p>
                        <p>Or copy and paste this link in your browser:<br>{$resetLink}</p>
                        <p><strong>This link will expire in 60 minutes.</strong></p>
                        <p>If you didn't request this password reset, you can ignore this email or contact support.</p>
                        <p>Best regards,<br>Nuzzle PetCare Team</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 Nuzzle PetCare. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }

    public function showResetPasswordForm(): void
    {
        $token = $_GET['token'] ?? '';
        $email = filter_var($_GET['email'] ?? '', FILTER_SANITIZE_EMAIL);

        if (empty($token) || empty($email)) {
            Session::flash('error', 'Invalid password reset link.');
            $this->redirect('/forgot-password');
            return;
        }

        $userModel = new User();
        $resetData = $userModel->verifyPasswordResetToken($token);

        if (!$resetData) {
            Session::flash('error', 'Password reset link has expired or is invalid.');
            $this->redirect('/forgot-password');
            return;
        }

        $this->render('auth/reset-password', [
            'pageTitle' => 'Reset Password',
            'token' => $token,
            'email' => $email
        ]);
    }

    public function handleResetPassword(): void
    {
        Session::start();
        $token = $_POST['token'] ?? '';
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($token) || empty($email) || empty($password) || empty($confirmPassword)) {
            Session::flash('error', 'All fields are required.');
            $this->redirect('/reset-password?email=' . urlencode($email) . '&token=' . urlencode($token));
            return;
        }

        if ($password !== $confirmPassword) {
            Session::flash('error', 'Passwords do not match.');
            $this->redirect('/reset-password?email=' . urlencode($email) . '&token=' . urlencode($token));
            return;
        }

        if (strlen($password) < 6) {
            Session::flash('error', 'Password must be at least 6 characters long.');
            $this->redirect('/reset-password?email=' . urlencode($email) . '&token=' . urlencode($token));
            return;
        }

        $userModel = new User();

        // Verify token before updating password
        $resetData = $userModel->verifyPasswordResetToken($token);
        if (!$resetData) {
            Session::flash('error', 'Password reset link has expired or is invalid.');
            $this->redirect('/forgot-password');
            return;
        }

        if ($userModel->updatePasswordByEmail($email, $password)) {
            Session::flash('success', 'Password has been reset successfully. You can now login.');
            $this->redirect('/login');
        } else {
            Session::flash('error', 'Failed to reset password. Please try again.');

            $this->redirect('/reset-password?token=' . urlencode($token));
        }
    }

    public function logout(): void
    {
        Session::start();
        Session::destroy();
        $this->redirect('/');
    }
}
