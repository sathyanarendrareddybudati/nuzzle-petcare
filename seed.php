<?php

// seed.php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Core/helpers.php'; 

use Dotenv\Dotenv;
use Database\Seeders\RoleSeeder;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if running from CLI
if (php_sapi_name() !== 'cli') {
    die("This script can only be run from the command line.");
}

// Instantiate and run the seeder
$seeder = new RoleSeeder();
$seeder->run();
