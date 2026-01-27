<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');
echo "VITE MANIFEST LOCATOR\n\n";

$basePath = realpath(__DIR__ . '/..');
$buildPath = $basePath . '/public/build';

echo "1. Checking manifest locations:\n";
$targets = [
    $buildPath . '/manifest.json',
    $buildPath . '/.vite/manifest.json',
];

foreach ($targets as $path) {
    echo "$path: " . (file_exists($path) ? "✅ EXISTS" : "❌ MISSING") . "\n";
}

echo "\n2. Contents of .vite directory (if exists):\n";
if (is_dir($buildPath . '/.vite')) {
    print_r(scandir($buildPath . '/.vite'));
} else {
    echo ".vite directory not found.\n";
}

echo "\n--- END LOCATOR ---\n";
echo "\nProceeding to Laravel Boot...\n\n";

require $basePath . '/vendor/autoload.php';
$app = require_once $basePath . '/bootstrap/app.php';
$app->handleRequest(Illuminate\Http\Request::capture());
