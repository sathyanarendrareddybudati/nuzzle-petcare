<?php
use App\Core\Session;
use App\Models\User;

Session::start();

// Fetch user role if logged in.
$userRole = null;
if (isset($_SESSION['user_id'])) {
    // This is a placeholder. In a real app, you would fetch the user's role from the database.
    // To test different roles, you can manually set a value here, e.g., $_SESSION['user_role'] = 'admin';
    if (!isset($_SESSION['user_role'])) {
        // Fallback or fetch from DB. For now, we'll default to 'owner' if not set.
        $_SESSION['user_role'] = 'owner'; 
    }
    $userRole = $_SESSION['user_role'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Nuzzle PetCare') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e59d9;
            --secondary-color: #1cc88a;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
            --font-family-sans-serif: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        body {
            font-family: var(--font-family-sans-serif);
            background-color: var(--light-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            font-weight: 600;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        .navbar .nav-link {
            color: var(--dark-color) !important;
            padding: 0.5rem 1rem;
            transition: color 0.2s;
        }
        .navbar .nav-link:hover, .navbar .nav-link.active {
            color: var(--primary-color) !important;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #264abf;
            border-color: #264abf;
        }
        .footer {
            background: #343a40;
            color: #fff;
            padding: 3rem 0;
        }
        .footer h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .footer .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
        }
        .footer .footer-links a:hover {
            color: #fff;
            padding-left: 5px;
        }
        .footer .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: background 0.3s;
        }
        .footer .social-links a:hover {
            background: var(--primary-color);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-paw me-2"></i>Nuzzle</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Aligned Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/"><i class="fas fa-home me-1"></i>Home</a></li>
                <?php if ($userRole === 'caretaker' || $userRole === null): ?>
                    <li class="nav-item"><a class="nav-link" href="/pets"><i class="fas fa-search me-1"></i>Browse Ads</a></li>
                <?php endif; ?>
                <?php if ($userRole === 'owner'): ?>
                    <li class="nav-item"><a class="nav-link" href="/caretakers"><i class="fas fa-search-plus me-1"></i>Browse Caretakers</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="/aboutus"><i class="fas fa-info-circle me-1"></i>About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact"><i class="fas fa-envelope me-1"></i>Contact</a></li>
            </ul>

            <!-- Right Aligned Links -->
            <ul class="navbar-nav align-items-center">
                <?php if ($userRole): // User is logged in ?>
                    <?php if ($userRole === 'owner'): ?>
                        <li class="nav-item me-2">
                            <a href="/pets/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Post an Ad</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://i.pravatar.cc/40?u=<?= e($_SESSION['user_id']) ?>" class="rounded-circle me-2" height="30" alt="User"/>
                            <?= e($_SESSION['user_name'] ?? 'Account') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if ($userRole === 'admin'): ?>
                                <li><a class="dropdown-item" href="/admin/dashboard"><i class="fas fa-user-shield me-2"></i>Admin Panel</a></li>
                                <li><a class="dropdown-item" href="/admin/users"><i class="fas fa-users-cog me-2"></i>Manage Users</a></li>
                                <li><a class="dropdown-item" href="/admin/ads"><i class="fas fa-list-alt me-2"></i>Manage Ads</a></li>
                            <?php elseif ($userRole === 'pet_owner'): ?>
                                <li><a class="dropdown-item" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="/my-ads"><i class="fas fa-list me-2"></i>My Ads</a></li>
                                <li><a class="dropdown-item" href="/messages"><i class="fas fa-inbox me-2"></i>Messages</a></li>
                            <?php elseif ($userRole === 'service_provider'): ?>
                                <li><a class="dropdown-item" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="/my-schedule"><i class="fas fa-calendar-alt me-2"></i>My Schedule</a></li>
                                <li><a class="dropdown-item" href="/messages"><i class="fas fa-inbox me-2"></i>Messages</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-user-edit me-2"></i>Edit Profile</a></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else: // Guest user ?>
                    <li class="nav-item">
                        <a href="/login" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="/register" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i>Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-4">
    <?php if ($m = Session::flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $m ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($m = Session::flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= $m ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<main>
    <?= $content ?>
</main>

<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-12">
                <h5><i class="fas fa-paw me-2"></i>Nuzzle PetCare</h5>
                <p class="text-white-50">More than care, we give love. Connecting pet owners with a community of trusted and passionate caretakers.</p>
                <div class="social-links d-flex mt-4">
                    <a href="#" class="d-flex align-items-center justify-content-center rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="d-flex align-items-center justify-content-center rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="d-flex align-items-center justify-content-center rounded-circle"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h5 class="mb-4">Company</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="/aboutus">About Us</a></li>
                    <li class="mb-2"><a href="#">Careers</a></li>
                    <li class="mb-2"><a href="/contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4">
                <h5 class="mb-4">Services</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="#">Pet Sitting</a></li>
                    <li class="mb-2"><a href="#">Dog Walking</a></li>
                    <li class="mb-2"><a href="#">Boarding</a></li>
                    <li class="mb-2"><a href="#">Fostering</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h5 class="mb-4">Stay Updated</h5>
                <p class="text-white-50">Subscribe to our newsletter for the latest news and offers.</p>
                <form>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email address..." aria-label="Your email address">
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,0.1)">
        <div class="text-center">
            <p class="small text-white-50 mb-0">&copy; <?= date('Y'); ?> Nuzzle PetCare. All Rights Reserved. | <a href="/terms" class="text-white-50 text-decoration-none">Terms of Service</a></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
