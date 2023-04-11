<?php

// file for retrieving data from database with AJAX

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
$sql = 'SELECT * FROM gamemerch WHERE id = ' . (int)$_REQUEST['id'];
$stmt = $pdo->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo $result[$_REQUEST["data"]];