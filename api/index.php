<?php

use Illuminate\Http\Request;

// 1. Force error reporting for the very early stages
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 2. Load Composer Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // 3. Start Laravel
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // 4. Ensure /tmp/views exists for Blade (Vercel Requirement)
    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0755, true);
    }

    // 5. Handle the request
    $app->handleRequest(Request::capture());

} catch (\Throwable $e) {
    // 6. Direct output if Laravel fails before handling the request
    header('Content-Type: text/plain', true, 500);
    echo "--- ENTRY POINT ERROR CAPTURED ---\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
}
