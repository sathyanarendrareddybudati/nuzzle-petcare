<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/Core/helpers.php';

if (class_exists(\Dotenv\Dotenv::class) && is_file(__DIR__ . '/.env')) {
    \Dotenv\Dotenv::createImmutable(__DIR__)->load();
}

use App\Core\Router;

$router = new Router();

require __DIR__ . '/routes/web.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$router->dispatch($_SERVER['REQUEST_METHOD'], rtrim($path, '/') ?: '/');
