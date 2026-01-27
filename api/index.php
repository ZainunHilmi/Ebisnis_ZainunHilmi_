<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');
echo "VITE ASSET DIAGNOSTIC\n\n";

$basePath = realpath(__DIR__ . '/..');
echo "Base Path: $basePath\n";

echo "\n1. Checking public directory:\n";
if (is_dir($basePath . '/public')) {
    echo "✅ /public exists.\n";
    print_r(scandir($basePath . '/public'));
} else {
    echo "❌ /public MISSING.\n";
}

echo "\n2. Checking public/build directory:\n";
if (is_dir($basePath . '/public/build')) {
    echo "✅ /public/build exists.\n";
    print_r(scandir($basePath . '/public/build'));
} else {
    echo "❌ /public/build MISSING.\n";
}

echo "\n3. Checking node_modules:\n";
echo "node_modules exists: " . (is_dir($basePath . '/node_modules') ? "✅" : "❌") . "\n";

echo "\n4. Environment Check:\n";
echo "NODE_ENV: " . getenv('NODE_ENV') . "\n";

echo "\n--- END DIAGNOSTIC ---\n";
echo "\nProceeding to Laravel Boot...\n\n";

require $basePath . '/vendor/autoload.php';
$app = require_once $basePath . '/bootstrap/app.php';
$app->handleRequest(Illuminate\Http\Request::capture());
