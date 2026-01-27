<?php

use Illuminate\Http\Request;

// 1. Manually set the base path for Vercel
$basePath = realpath(__DIR__ . '/..');

// 2. Load the composer autoloader
require $basePath . '/vendor/autoload.php';

// 3. Setup the Application
$app = require_once $basePath . '/bootstrap/app.php';

// 4. Handle the request
$app->handleRequest(Request::capture());
