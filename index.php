<?php
declare(strict_types=1);

// Start the session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/vendor/autoload.php';

// Load helpers
require_once __DIR__ . '/src/Core/helpers.php';

// Load .env here (no bootstrap/app.php file needed)
if (class_exists(\Dotenv\Dotenv::class) && is_file(__DIR__.'/.env')) {
    \Dotenv\Dotenv::createImmutable(__DIR__)->load();
}

use App\Core\Router;

$router = new Router();

// Load routes
require __DIR__ . '/routes/web.php';

// Dispatch
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$router->dispatch($_SERVER['REQUEST_METHOD'], rtrim($path, '/') ?: '/');
