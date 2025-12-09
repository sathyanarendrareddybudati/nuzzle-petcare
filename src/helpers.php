<?php

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $args
     * @return void
     */
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
    /**
     * Get / set the specified configuration value.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
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

// Add other helper functions as needed
