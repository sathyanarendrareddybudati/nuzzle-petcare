<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$pageTitle = 'Login - NUZZLE PetCare';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection and User model
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../models/User.php';
    
    // Get form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate input
    $errors = [];
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    if (empty($password)) {
        $errors[] = 'Please enter your password.';
    }
    
    // If no validation errors, attempt to authenticate user
    if (empty($errors)) {
        $user = new User();
        $authUser = $user->verifyCredentials($email, $password);
        
        if ($authUser) {
            $_SESSION['user_id'] = $authUser['id'];
            $_SESSION['user_name'] = $authUser['name'];
            $_SESSION['user_email'] = $authUser['email'];
            
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expires = time() + (30 * 24 * 60 * 60); // 30 days
                setcookie('remember_token', $token, $expires, '/', '', false, true);
            }
            
            // Redirect to dashboard or previous page
            $redirect = $_SESSION['redirect_after_login'] ?? '/';
            unset($_SESSION['redirect_after_login']);
            
            $_SESSION['success'] = 'You have been logged in successfully!';
            header('Location: ' . $redirect);
            exit;
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
    
    // If we get here, there were errors
    $_SESSION['error'] = implode('<br>', $errors);
    $_SESSION['form_data'] = [
        'email' => $email,
        'remember' => $remember
    ];
    
    // Redirect back to login page
    header('Location: /auth/login.php');
    exit;
}

// Include header
require_once __DIR__ . '/../includes/header.php';

// Get form data from session if available
$formData = $_SESSION['form_data'] ?? [
    'email' => '',
    'remember' => false
];
unset($_SESSION['form_data']);
?>

<!-- Add custom styles for the login page -->
<style>
    body {
        background-color: #f8f9fc;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
                        <p class="text-muted">Sign in to access your account</p>
                    </div>
                    
                    <form action="/auth/login.php" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($formData['email']); ?>" 
                                       placeholder="name@example.com" required>
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label">Password</label>
                                <a href="/auth/forgot-password.php" class="small">Forgot password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" 
                                        data-bs-toggle="tooltip" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Please enter your password.
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" 
                                   <?php echo $formData['remember'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        
                        <button class="btn btn-primary btn-lg w-100 mb-3" type="submit">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </button>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0">Don't have an account? 
                                <a href="/register.php">Create one</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    
    // Fetch the form we want to apply custom Bootstrap validation styles to
    var form = document.querySelector('.needs-validation')
    
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Prevent submission if form is invalid
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        
        form.classList.add('was-validated')
    }, false)
})()
</script>

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
