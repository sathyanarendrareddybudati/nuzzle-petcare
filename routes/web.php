<?php

use App\Controllers\HomeController;
use App\Controllers\PetsController;
use App\Controllers\AuthController;
use App\Controllers\ContactController;
use App\Controllers\AboutUsController;
use App\Controllers\AdminController;
use App\Controllers\DashboardController;

/** @var \App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

$router->get('/pets', [PetsController::class, 'index']);
$router->get('/pets/create', [PetsController::class, 'create']);
$router->post('/pets', [PetsController::class, 'store']);
$router->get('/pets/{id}', [PetsController::class, 'show']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/aboutus', [AboutUsController::class, 'index']);

$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit']);

// Forgot Password
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'handleForgotPasswordRequest']);

// Admin Routes
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/ads', [AdminController::class, 'ads']);

// Dashboard Route
$router->get('/dashboard', [DashboardController::class, 'index']);

$router->fallback(function () {
    http_response_code(404);
    require __DIR__ . '/../views/errors/404.php';
});
