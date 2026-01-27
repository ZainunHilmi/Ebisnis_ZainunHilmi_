<?php

use Illuminate\Http\Request;

// 1. Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Start Laravel and handle the request
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
