<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');
echo "--- VERCEL POST-DEPLOYMENT DIAGNOSTIC ---\n\n";

$root = dirname(__DIR__);
echo "Root Path: $root\n";

$checks = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'public/build/manifest.json',
    'vercel.json',
    '.env'
];

foreach ($checks as $file) {
    echo "$file: " . (file_exists($root . '/' . $file) ? "✅ EXISTS" : "❌ MISSING") . "\n";
}

if (is_dir($root . '/public/build')) {
    echo "\nContents of public/build:\n";
    print_r(scandir($root . '/public/build'));
}

echo "\nChecking Autoloader...\n";
if (file_exists($root . '/vendor/autoload.php')) {
    require $root . '/vendor/autoload.php';
    echo "✅ Autoloader loaded.\n";

    echo "\nChecking Laravel App...\n";
    if (file_exists($root . '/bootstrap/app.php')) {
        try {
            $app = require_once $root . '/bootstrap/app.php';
            echo "✅ App instance created.\n";
            echo "Laravel Version: " . $app->version() . "\n";

            echo "\nTrying to handle request...\n";
            $app->handleRequest(Illuminate\Http\Request::capture());
        } catch (\Throwable $e) {
            echo "❌ CRASH DURING BOOT/REQUEST:\n";
            echo $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
            echo "Trace:\n" . $e->getTraceAsString();
        }
    } else {
        echo "❌ bootstrap/app.php MISSING\n";
    }
} else {
    echo "❌ vendor/autoload.php MISSING. 'composer install' might have failed during build.\n";
}
