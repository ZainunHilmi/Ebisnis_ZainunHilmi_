<?php

use Illuminate\Http\Request;

// TEMPORARY: Show manifest content for debugging
if (isset($_GET['show_manifest'])) {
    header('Content-Type: text/plain');
    echo "=== MANIFEST DIAGNOSTIC ===\n\n";

    $root = dirname(__DIR__);
    $manifestPath = $root . '/public/build/manifest.json';

    echo "Manifest Path: $manifestPath\n";
    echo "Exists: " . (file_exists($manifestPath) ? "YES" : "NO") . "\n";

    if (file_exists($manifestPath)) {
        echo "Size: " . filesize($manifestPath) . " bytes\n";
        echo "\nManifest Content:\n";
        echo file_get_contents($manifestPath);
        echo "\n\n=== Parsed JSON ===\n";
        print_r(json_decode(file_get_contents($manifestPath), true));
    }

    echo "\n\n=== Asset Files Check ===\n";
    if (is_dir($root . '/public/build/assets')) {
        $assets = scandir($root . '/public/build/assets');
        foreach ($assets as $asset) {
            if ($asset !== '.' && $asset !== '..') {
                echo "$asset: " . filesize($root . '/public/build/assets/' . $asset) . " bytes\n";
            }
        }
    } else {
        echo "Assets directory not found!\n";
    }

    die();
}

define('LARAVEL_START', microtime(true));

// Create /tmp/views directory for compiled Blade templates
$viewsDir = '/tmp/views';
if (!is_dir($viewsDir)) {
    @mkdir($viewsDir, 0755, true);
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());
