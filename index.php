<?php

require "connect.php";

$host = '127.0.0.1';
$db   = 'merchstore';
$user = 'bit_academy';
$pass = 'bit_academy';

$dsn = "mysql:host=$host;dbname=$db;";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <nav class="topnav" id="myTopnav">
        <div>
            <h1 class="title">Merchandise</h1>
        </div>
        <div class="linkdiv">
            <div class="dropdown">
                <button class="dropbtn">Dropdown
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <?php foreach ($games as $game) : ?>
                        <a href="#"><?= $game ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="" class="links">Over ons</a>
        </div>
        <div>
            <a href="" class="links">Account</a>
        </div>
    </nav>
    <div class="newelem">
        <h2>Nieuwe items</h2>
        <div class="itemscroll">
            <div class="item">
                <h3>Itemnaam</h3>
                <img>
                <p></p>
            </div>
        </div>
    </div>
</body>

</html>