<?php

use Illuminate\Http\Request;

// 1. Manually set the base path for Vercel
$basePath = realpath(__DIR__ . '/..');

// 2. Load the composer autoloader
require $basePath . '/vendor/autoload.php';

// 3. Setup the Application
$app = require_once $basePath . '/bootstrap/app.php';

// 4. Debug Vite Manifest if missing
if (!file_exists($basePath . '/public/build/manifest.json')) {
    // Attempt to log or display where it is
    error_log("Vite Manifest Missing at: " . $basePath . '/public/build/manifest.json');
}

// 5. Handle the request
$app->handleRequest(Request::capture());
