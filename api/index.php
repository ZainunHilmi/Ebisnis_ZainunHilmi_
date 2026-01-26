<?php

// 1. Direct output to bypass any potential buffering issues
header('Content-Type: text/plain');
echo "Checking Filesystem...\n";

$root = dirname(__DIR__);
echo "Root: $root\n";

$files = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'config/app.php',
    '.env',
    'isrgrootx1.pem'
];

foreach ($files as $file) {
    echo "$file: " . (file_exists($root . '/' . $file) ? "✅" : "❌") . "\n";
}

echo "\nDirectory Listing of Root:\n";
print_r(scandir($root));

echo "\nTrying to load autoloader...\n";
if (file_exists($root . '/vendor/autoload.php')) {
    require $root . '/vendor/autoload.php';
    echo "Autoloader loaded.\n";
} else {
    echo "Autoloader MISSING. Cannot proceed to boot Laravel.\n";
}
