<?php

require "connect.php";

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();
$sql = "SELECT * FROM gamemerch WHERE voorraad > 0 ORDER BY id DESC;";
$newitems = $pdo->query($sql)->fetchAll();
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
    <?php require "nav.php"; ?>
    <div class="newitems">
        <h1>Nieuwe items</h1>
        <div class="itemscroll">
            <?php foreach ($newitems as $item) : ?>
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
    </div>
</body>

</html>