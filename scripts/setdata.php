<?php

// file for setting data in database with AJAX

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
$sql = 'UPDATE gamemerch SET voorraad = ' . (int)$_REQUEST['voorraad'] . ' WHERE id = ' . (int)$_REQUEST['id'] . ';';
$stmt = $pdo->query($sql);
$result = $stmt->execute();