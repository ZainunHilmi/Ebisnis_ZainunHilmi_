<?php

use Illuminate\Http\Request;

// 1. Manually set the base path for Vercel
$basePath = realpath(__DIR__ . '/..');

// 2. Load the composer autoloader
$autoloadPath = $basePath . '/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Fatal Error: Autoloader not found at $autoloadPath. Please ensure 'composer install' ran successfully.";
    exit;
}

require $autoloadPath;

// 3. Setup the Application
$appPath = $basePath . '/bootstrap/app.php';
if (!file_exists($appPath)) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Fatal Error: bootstrap/app.php not found at $appPath.";
    exit;
}

$app = require_once $appPath;

// 4. Trace the error if it fails here
try {
    $app->handleRequest(Request::capture());
} catch (\Exception $e) {
    header('Content-Type: text/plain');
    echo "Laravel Boot Error:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
