<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Vercel Deployment Debugger</h1>";

echo "<h2>Environment Variables Check</h2>";
$vars = [
    'APP_ENV',
    'APP_DEBUG',
    'APP_KEY',
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
    'MYSQL_ATTR_SSL_CA'
];

echo "<table border='1'>";
foreach ($vars as $var) {
    $val = getenv($var);
    $status = $val ? "✅ SET" : "❌ NOT SET";
    if ($var == 'APP_KEY' || $var == 'DB_PASSWORD')
        $val = "********";
    echo "<tr><td>$var</td><td>$status</td><td>$val</td></tr>";
}
echo "</table>";

echo "<h2>File System Check</h2>";
$ssl_ca = getenv('MYSQL_ATTR_SSL_CA');
$base_path = dirname(__DIR__);
$ca_path = $base_path . '/' . $ssl_ca;

echo "Base Path: $base_path<br>";
echo "Attempted CA Path: $ca_path<br>";

if ($ssl_ca && file_exists($ca_path)) {
    echo "✅ SSL CA Certificate Found!<br>";
} else {
    echo "❌ SSL CA Certificate NOT FOUND!<br>";
    echo "Files in root: <pre>";
    print_r(scandir($base_path));
    echo "</pre>";
}

echo "<h2>Database Connection Test</h2>";
try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $db = getenv('DB_DATABASE');
    $user = getenv('DB_USERNAME');
    $pass = getenv('DB_PASSWORD');

    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $ca_path,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ];

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, $options);

    echo "✅ Database Connection Successful!";
} catch (Exception $e) {
    echo "❌ Database Connection Failed: " . $e->getMessage();
}
