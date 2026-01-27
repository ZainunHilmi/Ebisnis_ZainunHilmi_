<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing TiDB Cloud Connection...<br>";

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$ssl_ca = getenv('MYSQL_ATTR_SSL_CA');

echo "Host: $host<br>";
echo "Port: $port<br>";
echo "Database: $db<br>";
echo "User: $user<br>";
echo "SSL CA: $ssl_ca<br>";

if (!$ssl_ca) {
    die("Error: MYSQL_ATTR_SSL_CA is not set in environment variables.");
}

$ca_path = realpath(__DIR__ . '/../' . $ssl_ca);
echo "Resolved SSL CA Path: " . ($ca_path ?: "FILE NOT FOUND") . "<br>";

if (!$ca_path || !file_exists($ca_path)) {
    echo "Checking current directory: " . __DIR__ . "<br>";
    echo "Files in root: <pre>";
    print_r(scandir(__DIR__ . '/../'));
    echo "</pre>";
}

try {
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $ca_path,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, $options);

    echo "Connection Successful!";
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}
