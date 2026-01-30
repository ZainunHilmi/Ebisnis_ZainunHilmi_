<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Clear all caches for Vercel deployment
$kernel->call('config:clear');
$kernel->call('route:clear');
$kernel->call('cache:clear');
$kernel->call('view:clear');

echo "Cache cleared successfully for Vercel deployment\n";