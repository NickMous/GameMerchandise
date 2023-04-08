<?php

require "connect.php";

$sql = "SELECT * FROM gamemerch WHERE id = ?";
$items = $pdo->prepare($sql);
$items->execute([$_GET["id"]]);
$product = $items->fetch();

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php foreach ($items as $item) : ?>
        <title><?= $product["naam"] ?></title>
    <?php endforeach; ?>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <?php require "nav.php" ?>
    <a href="index.php" class="backbutton"><h2>< Ga terug</h2></a>
    <div class="detail">
        <img src="media/itemimg/<?= $product["foto"] ?>" class="productimg">
        <div class="mgl">
            <h1><?= $product["naam"] ?></h1>
            <h2>€<?= $product["prijs"] ?></h2>
            <h4>Dit item komt uit <?= $product["game"] ?></h4>
            <p><?= $product["voorraad"] ?> op voorraad</p>
            <h3>Omschrijving:</h3>
            <p><?= $product["beschrijving"] ?></p>
            <button class="cartbtn shadow" onclick="add(<?= $product["id"] ?>)">In winkelwagen</button>
        </div>
    </div>
</body>

</html>