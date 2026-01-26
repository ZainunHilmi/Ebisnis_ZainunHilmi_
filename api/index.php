<?php

use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;

// 1. Force the working directory to the project root
chdir(__DIR__ . '/..');

// 2. Clear any stale cache that might have been bundled
if (file_exists('bootstrap/cache/services.php')) {
    @unlink('bootstrap/cache/services.php');
}
if (file_exists('bootstrap/cache/packages.php')) {
    @unlink('bootstrap/cache/packages.php');
}
if (file_exists('bootstrap/cache/config.php')) {
    @unlink('bootstrap/cache/config.php');
}

// 3. Load Composer
require __DIR__ . '/../vendor/autoload.php';

// 4. Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Handle the request
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
