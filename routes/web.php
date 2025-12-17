<?php

use App\Controllers\HomeController;
use App\Controllers\PetAdsController;
use App\Controllers\AuthController;
use App\Controllers\ContactController;
use App\Controllers\AboutUsController;
use App\Controllers\AdminController;
use App\Controllers\DashboardController;
use App\Controllers\CaretakerProfileController;
use App\Controllers\CaretakerProfilesController;
use App\Controllers\MessageController;
use App\Controllers\MyPetsController;
use App\Controllers\FaqController;

/** @var \App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

// Pet Ads
$router->get('/pets', [PetAdsController::class, 'index']);
$router->get('/my-pets/create', [PetAdsController::class, 'create']); // Changed from /pets/create
$router->post('/pets', [PetAdsController::class, 'store']);
$router->get('/pets/{id}', [PetAdsController::class, 'show']);
$router->get('/pets/{id}/edit', [PetAdsController::class, 'edit']);
$router->post('/pets/{id}', [PetAdsController::class, 'update']);
$router->post('/pets/{id}/delete', [PetAdsController::class, 'destroy']);

$router->get('/my-pets', [MyPetsController::class, 'index']);

$router->get('/caretakers', [CaretakerProfilesController::class, 'index']);

// Auth
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/register/admin', [AuthController::class, 'showAdminRegisterForm']);
$router->post('/register/admin', [AuthController::class, 'registerAdmin']);
$router->get('/logout', [AuthController::class, 'logout']);

// Static Pages
$router->get('/aboutus', [AboutUsController::class, 'index']);
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit']);

// FAQ Page
$router->get('/faq', [FaqController::class, 'index']);

// Forgot Password
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'handleForgotPasswordRequest']);

// Admin Routes
$router->get('/admin', [AdminController::class, 'index'])->middleware('AdminMiddleware');
$router->get('/admin/dashboard', [AdminController::class, 'index'])->middleware('AdminMiddleware');
$router->get('/admin/users', [AdminController::class, 'users'])->middleware('AdminMiddleware');
$router->get('/admin/ads', [AdminController::class, 'ads'])->middleware('AdminMiddleware');

// Dashboard Route
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/dashboard/caretaker', [DashboardController::class, 'caretaker']);

// Messages
$router->get('/messages', [MessageController::class, 'index']);
$router->get('/messages/chat', [MessageController::class, 'chat']);
$router->post('/messages/send', [MessageController::class, 'send']);

// Caretaker Profile
$router->get('/caretaker/profile', [CaretakerProfileController::class, 'create']);
$router->post('/caretaker/profile/store', [CaretakerProfileController::class, 'store']);


$router->fallback(function () {
    http_response_code(404);
    require __DIR__ . '/../views/errors/404.php';
});
