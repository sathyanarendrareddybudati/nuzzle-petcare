<?php
// src/Core/helpers.php

if (!function_exists('redirect')) {
    /**
     * Redirect to a given URL.
     *
     * @param string $path
     * @return void
     */
    function redirect(string $path): void
    {
        header("Location: {$path}");
        exit();
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML special characters in a string.
     *
     * @param string|null $value
     * @return string
     */
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}
