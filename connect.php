<?php

// this file is required almost everywhere. it loads the session and database

session_start();

if (!isset($_SESSION["logged"])) {
    $_SESSION["logged"] = false;
}

$host = 'localhost';
$db   = 'sdhmerchstore';
$user = 'bit_academy';
$pass = 'bit_academy';

$dsn = "mysql:host=$host;dbname=$db;";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}