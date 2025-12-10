<?php

use App\Controllers\HomeController;
use App\Controllers\PetsController;
use App\Controllers\AuthController;
use App\Controllers\ContactController;

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

$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit']);

$router->fallback(function () {
    http_response_code(404);
    require __DIR__ . '/../views/errors/404.php';
});
