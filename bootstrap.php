<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Start session
Session::start();

// Load routes and dispatch
$router = new Router();
require_once __DIR__ . '/routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI']);

// Load Firebase configuration
$firebaseConfig = require_once __DIR__ . '/config/firebase.php';
