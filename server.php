<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */
$env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'local';
$envFile = __DIR__ . "/.env.{$env}";

// Jika file .env sesuai APP_ENV ada, pakai itu
if (file_exists($envFile)) {
    copy($envFile, __DIR__.'/.env');
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
