<?php

return [
    'name' => 'NUZZLE PetCare',
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost:8000'),
    'timezone' => env('TIMEZONE', 'UTC'),
    'key' => env('APP_KEY', ''),
    'cipher' => 'AES-256-CBC',
];
