<?php

echo "<h1>Vercel Autoload Debugger</h1>";

$root = dirname(__DIR__);
$autoload = $root . '/vendor/autoload.php';

echo "Checking: $autoload<br>";

if (file_exists($autoload)) {
    echo "✅ autoload.php found!<br>";
    require $autoload;
    echo "✅ autoload.php required successfully!<br>";

    if (class_exists(\Illuminate\View\ViewServiceProvider::class)) {
        echo "✅ ViewServiceProvider class found!<br>";
    } else {
        echo "❌ ViewServiceProvider class NOT found!<br>";
    }
} else {
    echo "❌ autoload.php NOT found!<br>";
    echo "Files in root: <pre>";
    print_r(scandir($root));
    echo "</pre>";
}
