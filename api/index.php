<?php

use Illuminate\Http\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Start Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Handle Request with Error Capture
try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    header('Content-Type: text/plain', true, 500);
    echo "--- FATAL ERROR CAPTURED ---\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
}
