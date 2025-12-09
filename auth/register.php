<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$pageTitle = 'Create Account - PetCare';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../models/User.php';
    
    $name = trim($_POST['name'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Please enter your full name.';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }
    
    // If no validation errors, proceed with registration
    if (empty($errors)) {
        $user = new User();
        
        // Check if email already exists
        if ($user->emailExists($email)) {
            $errors[] = 'An account with this email already exists.';
        } else {
            // Get and validate role (2 for pet_owner, 3 for service_provider)
            $roleId = (int)($_POST['role_id'] ?? 0);
            if (!in_array($roleId, [2, 3])) {
                $errors[] = 'Please select a valid role.';
                $_SESSION['form_data'] = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'error' => 'Please select a valid role.'
                ];
                header('Location: register.php');
                exit;
            }
            
            // Create new user
            $userId = $user->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'role_id' => $roleId
            ]);
            
            if ($userId) {
                // Log the user in
                $authUser = $user->getById($userId);
                
                if ($authUser) {
                    $_SESSION['user_id'] = $authUser['id'];
                    $_SESSION['user_name'] = $authUser['name'];
                    $_SESSION['user_email'] = $authUser['email'];
                    
                    $_SESSION['success'] = 'Your account has been created successfully!';
                    header('Location: /');
                    exit;
                } else {
                    $errors[] = 'Registration successful, but there was an issue logging you in. Please try logging in manually.';
                }
            } else {
                $errors[] = 'There was an error creating your account. Please try again.';
            }
        }
    }
    
    // If we get here, there were errors
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        $_SESSION['form_data'] = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        
        // Redirect back to registration page
        header('Location: register.php');
        exit;
    }
}

// Include header
require_once __DIR__ . '/../includes/header.php';

// Get form data from session if available
$formData = $_SESSION['form_data'] ?? [
    'name' => '',
    'email' => '',
    'phone' => ''
];
unset($_SESSION['form_data']);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 font-weight-normal">Create an Account</h1>
                        <p class="text-muted">Join our community today</p>
                    </div>
                    
                    <form action="register.php" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($formData['name']); ?>" 
                                   placeholder="John Doe" required>
                            <div class="invalid-feedback">
                                Please enter your full name.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($formData['email']); ?>" 
                                   placeholder="name@example.com" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Register as:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_id" id="role_pet_owner" value="3" required>
                                <label class="form-check-label" for="role_pet_owner">
                                    Pet Owner
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="role_id" id="role_service_provider" value="4" required>
                                <label class="form-check-label" for="role_service_provider">
                                    Service Provider
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number (Optional)</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($formData['phone']); ?>" 
                                   placeholder="+1 (123) 456-7890">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Create a password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Must be at least 8 characters long.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" 
                                       name="confirm_password" placeholder="Confirm your password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Passwords must match.
                            </div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="/terms" target="_blank">Terms of Service</a> and 
                                <a href="/privacy" target="_blank">Privacy Policy</a>
                            </label>
                            <div class="invalid-feedback">
                                You must agree to the terms and conditions.
                            </div>
                        </div>
                        
                        <button class="btn btn-primary btn-lg w-100 mb-3" type="submit">
                            <i class="fas fa-user-plus me-2"></i> Create Account
                        </button>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0">Already have an account? 
                                <a href="login.php">Sign in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation and password toggle
(function () {
    'use strict';
    
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
    
    // Form validation
    const form = document.querySelector('.needs-validation');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.onchange = validatePassword;
    confirmPassword.onkeyup = validatePassword;
    
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    }, false);
})();
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
