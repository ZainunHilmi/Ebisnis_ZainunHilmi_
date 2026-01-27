<?php

use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Path Setup
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';

// 2. Capture the actual error during bootstrap
try {
    // This is what Laravel 11/12 does inside handleRequest
    // We do it manually to catch the early crash
    $kernel = $app->make(Kernel::class);

    // Trigger bootstrap steps manually to catch the fly
    $method = new ReflectionMethod(get_class($kernel), 'bootstrap');
    $method->setAccessible(true);
    $method->invoke($kernel);

    echo "✅ Bootstrap Successful. Finalizing request...\n";

    // If we reach here, bootstrap worked. Now handle the request.
    $app->handleRequest(Request::capture());

} catch (\Throwable $e) {
    header('Content-Type: text/plain', true, 500);
    echo "!!! ROOT CAUSE ERROR DETECTED !!!\n\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line " . $e->getLine() . ")\n\n";
    echo "Stack Trace:\n";
    echo $e->getTraceAsString();
    exit;
}
