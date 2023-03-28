<?php

require "connect.php";

$sql = "SELECT * FROM gamemerch WHERE game = ?";
$items = $pdo->prepare($sql);
$items->execute([$_GET["game"]]);
$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_GET["game"] ?></title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <?php require "nav.php" ?>
    <h1 class="mgl"><?= $_GET["game"] ?></h1>
    <div class="collectiondiv">
        <?php foreach ($items as $item) : ?>
            <a href="detail.php?id=<?= $item["id"] ?>">
                <div class="item shadow">
                    <div>
                        <h3 class="mg"><?= $item["naam"] ?></h3>
                        <img src="media/itemimg/<?= $item["foto"] ?>" class="itemimg">
                    </div>
                    <a href="detail.php?id=<?= $item["id"] ?>">Ga naar item ></a>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</body>

</html>