<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');
echo "--- VERCEL ASSET DIAGNOSTIC ---\n\n";

$root = dirname(__DIR__);
echo "Root Path: $root\n";

echo "\n=== CHECKING CRITICAL FILES ===\n";
$checks = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'public/build/manifest.json',
    'public/build/assets',
    'isrgrootx1.pem'
];

foreach ($checks as $file) {
    $path = $root . '/' . $file;
    if (is_file($path)) {
        echo "$file: ✅ FILE (" . filesize($path) . " bytes)\n";
    } elseif (is_dir($path)) {
        echo "$file: ✅ DIRECTORY\n";
    } else {
        echo "$file: ❌ MISSING\n";
    }
}

echo "\n=== PUBLIC/BUILD DIRECTORY ===\n";
if (is_dir($root . '/public/build')) {
    echo "Contents:\n";
    $buildFiles = scandir($root . '/public/build');
    foreach ($buildFiles as $file) {
        if ($file !== '.' && $file !== '..') {
            $path = $root . '/public/build/' . $file;
            if (is_dir($path)) {
                echo "  📁 $file/\n";
            } else {
                echo "  📄 $file (" . filesize($path) . " bytes)\n";
            }
        }
    }
} else {
    echo "❌ public/build directory does not exist\n";
}

echo "\n=== PUBLIC/BUILD/ASSETS DIRECTORY ===\n";
if (is_dir($root . '/public/build/assets')) {
    echo "Contents:\n";
    $assetFiles = scandir($root . '/public/build/assets');
    foreach ($assetFiles as $file) {
        if ($file !== '.' && $file !== '..') {
            $path = $root . '/public/build/assets/' . $file;
            $size = filesize($path);
            $sizeKB = round($size / 1024, 2);
            echo "  📄 $file ($sizeKB KB)\n";
        }
    }
} else {
    echo "❌ public/build/assets directory DOES NOT EXIST\n";
    echo "\n🔍 This is likely why CSS/JS files aren't loading!\n";
    echo "The Vite build files are not being deployed to Vercel.\n";
}

echo "\n=== VERCEL BUILD ENVIRONMENT ===\n";
echo "VERCEL env: " . (getenv('VERCEL') ?: 'not set') . "\n";
echo "NODE_ENV: " . (getenv('NODE_ENV') ?: 'not set') . "\n";

echo "\n=== END OF DIAGNOSTIC ===\n";
echo "This diagnostic will help us identify why assets aren't loading.\n";

// Stop here - don't run Laravel
die();
