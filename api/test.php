<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "--- PHP ENVIRONMENT DIAGNOSTIC ---\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Current Directory: " . getcwd() . "\n";
echo "Script Path: " . __FILE__ . "\n";
echo "Root Path (assumed): " . dirname(__DIR__) . "\n";

echo "\n--- LOADED EXTENSIONS ---\n";
print_r(get_loaded_extensions());

echo "\n--- DIR LISTING (ROOT) ---\n";
print_r(scandir(dirname(__DIR__)));

echo "\n--- PHP INFO ---\n";
phpinfo();
