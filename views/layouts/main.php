<?php use App\Core\Session; Session::start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'PetCare') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            background-color: var(--light-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main { flex: 1; }
        .navbar {
            background: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 0.5rem 0;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
        }
        .navbar-nav .nav-link {
            font-weight: 600;
            color: var(--dark-color) !important;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        .navbar-nav .nav-link i { margin-right: 0.3rem; }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
        }
        .btn-primary:hover { background-color: #2e59d9; border-color: #2653d4; }
        .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
        .btn-outline-primary:hover { background-color: var(--primary-color); color: white; }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 4rem 0 2rem;
            margin-top: auto;
        }
        .footer h5 { color: white; font-weight: 600; margin-bottom: 1.5rem; }
        .footer p { color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem; }
        .footer .social-links a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; background: rgba(255, 255, 255, 0.1);
            border-radius: 50%; color: white; margin-right: 0.75rem; transition: all 0.3s;
        }
        .footer .social-links a:hover { background: var(--primary-color); transform: translateY(-3px); }
        .footer ul.list-unstyled li { margin-bottom: 0.75rem; }
        .footer ul.list-unstyled a {
            color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s; display: inline-block;
        }
        .footer ul.list-unstyled a:hover { color: white; transform: translateX(5px); }
        .footer .form-control {
            background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white;
        }
        .footer .form-control:focus {
            background: rgba(255, 255, 255, 0.15); border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25); color: white;
        }
        .footer .form-control::placeholder { color: rgba(255, 255, 255, 0.5); }
        .footer .btn-primary { background: var(--primary-color); border-color: var(--primary-color); }
        .footer .btn-primary:hover { background: #2e59d9; border-color: #2e59d9; }
        .footer hr { border-color: rgba(255, 255, 255, 0.1); }
        .footer .text-muted { color: rgba(255, 255, 255, 0.5) !important; }
        .dropdown-menu {
            border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.2);
            border-radius: 0.5rem; padding: 0.5rem 0;
        }
        .dropdown-item { padding: 0.5rem 1.5rem; font-weight: 500; color: var(--dark-color); }
        .dropdown-item:hover { background-color: #f8f9fa; color: var(--primary-color); }
        .dropdown-divider { margin: 0.5rem 0; border-top: 1px solid #e3e6f0; }
        @media (max-width: 991.98px) {
            .navbar-collapse { padding: 1rem 0; }
            .navbar-nav { margin-bottom: 1rem; }
            .d-flex.align-items-center { flex-direction: column; width: 100%; }
            .ms-3, .ms-2 { margin-left: 0 !important; margin-top: 0.5rem; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-paw me-2"></i>PetCare</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/pets"><i class="fas fa-paw"></i> Browse Pets</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact"><i class="fas fa-envelope"></i> Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="/aboutus"><i class="fas fa-envelope"></i> About Us</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <div class="dropdown ms-3">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            <?= e($_SESSION['user_name'] ?? 'My Account') ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="/my-pets"><i class="fas fa-paw me-2"></i>My Pets</a></li>
                            <li><a class="dropdown-item" href="/my-favorites"><i class="fas fa-heart me-2"></i>Favorites</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-user-edit me-2"></i>Edit Profile</a></li>
                            <li><a class="dropdown-item" href="/settings"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                    <a href="/pets/create" class="btn btn-primary ms-2"><i class="fas fa-plus me-2"></i>List a Pet</a>
                <?php else: ?>
                    <div class="btn-group ms-3">
                        <a href="/login" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        <a href="/register" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i>Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <?php if ($m = Session::flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $m ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($m = Session::flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $m ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<main class="py-4">
    <div class="container">
        <?= $content ?>
    </div>
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
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="mb-4">Contact Us</h5>
                <ul class="list-unstyled contact-info">
                    <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt me-3 mt-1"></i><span>123 Pet Street, City, Country</span></li>
                    <li class="mb-3 d-flex"><i class="fas fa-phone me-3 mt-1"></i><a href="tel:+1234567890" class="text-decoration-none">+1 234 567 890</a></li>
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
            <div class="col-md-6 text-center text-md-end">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
