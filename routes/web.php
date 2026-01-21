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
use App\Controllers\MessagesController;
use App\Controllers\MyPetsController;
use App\Controllers\FaqController;
use App\Controllers\BookingsController;
use App\Controllers\ProfileController;
use App\Controllers\TermsOfServiceController;
use App\Controllers\PrivacyPolicyController;

/** @var \App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

// Pet Ads
$router->get('/pets', [PetAdsController::class, 'index']);
$router->get('/pets/create', [PetAdsController::class, 'create']);
$router->post('/pets', [PetAdsController::class, 'store']);
$router->get('/pets/{id}', [PetAdsController::class, 'show']);
$router->get('/pets/{id}/edit', [PetAdsController::class, 'edit']);
$router->post('/pets/{id}', [PetAdsController::class, 'update']);
$router->post('/pets/{id}/delete', [PetAdsController::class, 'destroy']);

// My Pets (Pet Profile Management)
$router->get('/my-pets', [MyPetsController::class, 'index'])->middleware('PetOwnerMiddleware');
$router->get('/my-pets/create', [MyPetsController::class, 'create'])->middleware('PetOwnerMiddleware');
$router->post('/my-pets/create-from-ad', [MyPetsController::class, 'createFromAd'])->middleware('PetOwnerMiddleware');
$router->post('/my-pets', [MyPetsController::class, 'store'])->middleware('PetOwnerMiddleware');
$router->get('/my-pets/{id}/edit', [MyPetsController::class, 'edit'])->middleware('PetOwnerMiddleware');
$router->post('/my-pets/{id}', [MyPetsController::class, 'update'])->middleware('PetOwnerMiddleware');
$router->delete('/my-pets/{id}', [MyPetsController::class, 'destroy'])->middleware('PetOwnerMiddleware');


// Bookings
$router->get('/bookings', [BookingsController::class, 'index']);
$router->get('/bookings/create/{caretakerId}', [BookingsController::class, 'create']);
$router->post('/bookings', [BookingsController::class, 'store']);
$router->get('/bookings/manage/{id}', [BookingsController::class, 'manage']);
$router->post('/bookings/update/{id}', [BookingsController::class, 'update']);
$router->post('/bookings/rate/{id}', [BookingsController::class, 'rate']);

// Caretaker Profile
// IMPORTANT: Specific routes must come before wildcard routes.
$router->get('/caretaker/profile', [CaretakerProfileController::class, 'create']);
$router->post('/caretaker/profile/store', [CaretakerProfileController::class, 'store']);
$router->get('/caretakers', [CaretakerProfilesController::class, 'index']);
$router->get('/caretaker/{id}', [CaretakerProfilesController::class, 'show']);


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
$router->get('/terms-of-service', [TermsOfServiceController::class, 'index']);
$router->get('/privacy-policy', [PrivacyPolicyController::class, 'index']);

// FAQ Page
$router->get('/faq', [FaqController::class, 'index']);

// Forgot Password & Reset Password
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'handleForgotPasswordRequest']);
$router->get('/reset-password', [AuthController::class, 'showResetPasswordForm']);
$router->post('/reset-password', [AuthController::class, 'handleResetPassword']);

// Profile
$router->get('/profile', [ProfileController::class, 'index'])->middleware('AuthMiddleware');
$router->post('/profile/update', [ProfileController::class, 'update'])->middleware('AuthMiddleware');
$router->post('/profile/update-password', [ProfileController::class, 'updatePassword'])->middleware('AuthMiddleware');


// Admin Routes
$router->get('/admin', [AdminController::class, 'index'])->middleware('AdminMiddleware');
$router->get('/admin/dashboard', [AdminController::class, 'index'])->middleware('AdminMiddleware');
$router->get('/admin/users', [AdminController::class, 'users'])->middleware('AdminMiddleware');
$router->get('/admin/ads', [AdminController::class, 'ads'])->middleware('AdminMiddleware');
$router->get('/admin/users/edit/{id}', [AdminController::class, 'editUser'])->middleware('AdminMiddleware');
$router->post('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->middleware('AdminMiddleware');
$router->post('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->middleware('AdminMiddleware');
$router->get('/admin/content', [AdminController::class, 'content'])->middleware('AdminMiddleware');

// FAQ Admin
$router->get('/admin/faq', [FaqController::class, 'adminIndex'])->middleware('AdminMiddleware');
$router->get('/admin/faq/create', [FaqController::class, 'create'])->middleware('AdminMiddleware');
$router->post('/admin/faq', [FaqController::class, 'store'])->middleware('AdminMiddleware');
$router->get('/admin/faq/edit/{id}', [FaqController::class, 'edit'])->middleware('AdminMiddleware');
$router->post('/admin/faq/update/{id}', [FaqController::class, 'update'])->middleware('AdminMiddleware');
$router->post('/admin/faq/delete/{id}', [FaqController::class, 'destroy'])->middleware('AdminMiddleware');


// Dashboard Route
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/dashboard/caretaker', [DashboardController::class, 'caretaker']);

// Messages
$router->get('/messages', [MessagesController::class, 'index']);
$router->get('/messages/create/{recipientId}', [MessagesController::class, 'create']);
$router->post('/messages', [MessagesController::class, 'store']);
$router->get('/messages/{participantId}', [MessagesController::class, 'show']);

$router->fallback(function () {
    http_response_code(404);
    require __DIR__ . '/../views/errors/404.php';
});