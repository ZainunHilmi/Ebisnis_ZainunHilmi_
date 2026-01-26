<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');
echo "PHASE 1: ENVIRONMENT CHECK\n";
echo "Current PHP: " . PHP_VERSION . "\n";
echo "Current Dir: " . __DIR__ . "\n";
echo "Root Path: " . realpath(__DIR__ . '/..') . "\n";

$vendor = __DIR__ . '/../vendor/autoload.php';
echo "Checking Vendor: $vendor -> " . (file_exists($vendor) ? "✅" : "❌") . "\n";

$bootstrap = __DIR__ . '/../bootstrap/app.php';
echo "Checking Bootstrap: $bootstrap -> " . (file_exists($bootstrap) ? "✅" : "❌") . "\n";

if (file_exists($vendor)) {
    echo "PHASE 2: LOADING AUTOLOADER\n";
    require $vendor;
    echo "✅ Autoloader Loaded.\n";

    if (class_exists(\Illuminate\Foundation\Application::class)) {
        echo "✅ Laravel Application class found.\n";
    } else {
        echo "❌ Laravel Application class NOT found!\n";
    }
}

if (file_exists($bootstrap)) {
    echo "PHASE 3: BOOTSTRAPPING APP\n";
    try {
        $app = require_once $bootstrap;
        echo "✅ App instance created.\n";
        echo "Laravel Version: " . $app->version() . "\n";

        echo "Checking if [view] is bound...\n";
        if ($app->bound('view')) {
            echo "✅ 'view' is bound.\n";
        } else {
            echo "❌ 'view' is NOT bound.\n";
        }

    } catch (\Throwable $e) {
        echo "❌ BOOTSTRAP FAILED!\n";
        echo "Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
        echo "Stack Trace:\n" . $e->getTraceAsString() . "\n";
    }
}
echo "\n--- END OF DIAGNOSTIC ---\n";
