<?php

if (!function_exists('dd')) {
    function dd(...$args)
    {
        foreach ($args as $x) {
            echo '<pre>';
            var_dump($x);
            echo '</pre>';
        }
        die(1);
    }
}

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        static $config = null;

        if (is_null($config)) {
            $config = require __DIR__ . '/../config/app.php';
        }

        if (is_null($key)) {
            return $config;
        }

        return $config[$key] ?? $default;
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}
