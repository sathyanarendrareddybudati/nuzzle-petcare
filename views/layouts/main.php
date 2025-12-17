<?php
use App\Core\Session;

Session::start();

$user = Session::get('user');
$userRole = $user['role'] ?? null;
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
            background: #2c3e50;
            color: white;
            padding: 4rem 0 2rem;
            margin-top: auto;
        }
        .dropdown-menu {
            border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.2);
            border-radius: 0.5rem; padding: 0.5rem 0;
        }
        .dropdown-item { padding: 0.5rem 1.5rem; font-weight: 500; color: var(--dark-color); }
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
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/pets">Browse Pets</a></li>
                <li class="nav-item"><a class="nav-link" href="/caretakers">Find a Caretaker</a></li>
                <li class="nav-item"><a class="nav-link" href="/aboutus">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="/faq">Faqs</a></li>
            </ul>

            <ul class="navbar-nav align-items-center">
                <?php if ($user): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://i.pravatar.cc/40?u=<?= e($user['id']) ?>" class="rounded-circle me-2" height="30" alt="User"/>
                            <?= e($user['name'] ?? 'Account') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if ($userRole === 'admin'): ?>
                                <li><a class="dropdown-item" href="/admin/dashboard">Admin Panel</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                                <?php if ($userRole === 'pet_owner'): ?>
                                    <li><a class="dropdown-item" href="/my-pets">My Pets</a></li>
                                <?php endif; ?>
                                <?php if ($userRole === 'service_provider'): ?>
                                    <li><a class="dropdown-item" href="/caretaker/profile">My Profile</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="/messages">Messages</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="/register" class="btn btn-primary">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-4">
    <?php if ($m = Session::flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert"><?= $m ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if ($m = Session::flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $m ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
</div>

<main>
    <?= $content ?? '' ?>
</main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="mb-4">About PetCare</h5>
                    <p class="mb-4">Connecting loving homes with wonderful pets.</p>
                    <div class="social-links d-flex">
                        <a href="#" class="d-flex align-items-center justify-content-center me-3" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="d-flex align-items-center justify-content-center me-3" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="d-flex align-items-center justify-content-center me-3" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="d-flex align-items-center justify-content-center" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="/" class="d-flex align-items-center"><i class="fas fa-chevron-right me-2 small"></i> Home</a></li>
                        <li class="mb-2"><a href="/pets" class="d-flex align-items-center"><i class="fas fa-chevron-right me-2 small"></i> Browse Pets</a></li>
                        <li class="mb-2"><a href="/contact" class="d-flex align-items-center"><i class="fas fa-chevron-right me-2 small"></i> Contact</a></li>
                        <li class="mb-2"><a href="/register/admin" class="d-flex align-items-center"><i class="fas fa-chevron-right me-2 small"></i> Admin Registration</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class_name="mb-4">Contact Us</h5>
                    <ul class="list-unstyled contact-info">
                        <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt me-3 mt-1"></i><span>28, rue Notre des Champs ,Paris, France</span></li>
                        <li class="mb-3 d-flex"><i class="fas fa-phone me-3 mt-1"></i><a href="tel:+33 78965432" class="text-decoration-none">+33 78965432</a></li>
                        <li class="mb-3 d-flex"><i class="fas fa-envelope me-3 mt-1"></i><a href="mailto:info@petcare.com" class="text-decoration-none">info@petcare.com</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="mb-4">Newsletter</h5>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                            <button class="btn btn-primary px-3" type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacyPolicy" required>
                            <label class="form-check-label small" for="privacyPolicy">I agree to the <a href="#" class="text-decoration-underline">Privacy Policy</a></label>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 border-light opacity-10">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 small">&copy; <?= date('Y'); ?> PetCare. All rights reserved.</p>
                </div>
                <div class_name="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-decoration-none small">Privacy Policy</a></li>
                        <li class="list-inline-item"><span class="mx-2">•</span></li>
                        <li class="list-inline-item"><a href="#" class="text-decoration-none small">Terms of Service</a></li>
                        <li class="list-inline-item"><span class="mx-2">•</span></li>
                        <li class="list-inline-item"><a href="#" class="text-decoration-none small">Sitemap</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
