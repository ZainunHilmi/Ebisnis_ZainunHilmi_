<?php

/**
 * Quick Test for Session Isolation
 * 
 * Run: php test-isolation.php
 */

require __DIR__ . '/vendor/autoload.php';

$tests = [
    'SessionIsolation middleware exists' => file_exists(__DIR__ . '/app/Http/Middleware/SessionIsolation.php'),
    'VerifyCsrfToken middleware exists' => file_exists(__DIR__ . '/app/Http/Middleware/VerifyCsrfToken.php'),
    'Kernel updated' => strpos(file_get_contents(__DIR__ . '/app/Http/Kernel.php'), 'SessionIsolation') !== false,
    'Migration exists' => count(glob(__DIR__ . '/database/migrations/*_add_guard_to_sessions_table.php')) > 0,
];

echo "=== SESSION ISOLATION TEST ===\n\n";

$passed = 0;
$failed = 0;

foreach ($tests as $name => $result) {
    if ($result) {
        echo "✓ PASS: $name\n";
        $passed++;
    } else {
        echo "✗ FAIL: $name\n";
        $failed++;
    }
}

echo "\n=== RESULT ===\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";

if ($failed === 0) {
    echo "\n✓ All tests passed!\n";
    echo "\nNext steps:\n";
    echo "1. Run: php artisan migrate\n";
    echo "2. Clear cache: php artisan cache:clear\n";
    echo "3. Test login in two tabs\n";
    exit(0);
} else {
    echo "\n✗ Some tests failed\n";
    exit(1);
}
