<?php

require "connect.php";

if ($_SESSION["logged"]) {
    $sql = "SELECT * FROM userdata WHERE username = ?;";
    $users = $pdo->prepare($sql);
    $users->execute([$_SESSION["username"]]);
    $user = $users->fetch();
    $name = $_SESSION["username"];
    $logged = true;
} else {
    $name = "Account";
    $logged = false;
    header("Location: index.php");
}

if ($user["admin"] == "no") {
    header("Location: index.php?no");
}

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();
$sql = "SELECT id FROM gamemerch;";
$productcount = 0;
$stmt = $pdo->prepare($sql);
$stm = $stmt->execute();
foreach ($stmt as $ah) {
    $productcount++;
}

$sql = "SELECT id FROM userdata;";
$accountcount = 0;
$stmt = $pdo->prepare($sql);
$stm = $stmt->execute();
foreach ($stmt as $ah) {
    $accountcount++;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <nav class="topnav" id="myTopnav">
        <div>
            <a href="index.php">
                <h1 class="title">Merchandise</h1>
            </a>
        </div>
        <div class="linkdiv">
            <a href="manageusers.php" class="links">Users</a>
            <a href="productlist.php" class="links">Products</a>
            <a href="addproduct.php" class="links">Add product</a>
        </div>
        <?php if ($logged) : ?>
            <div class="linkdiv account">
                <?php if (isset($user["pfp"])) : ?>
                    <img src="media/pfp/<?= $user["pfp"] ?>" alt="">
                <?php endif; ?>
                <div class="dropdown">
                    <button class="dropbtn"><?= $name ?>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content accountcontent">
                        <a href="favs.php">Favorieten</a>
                        <a href="profile.php">Mijn profiel</a>
                        <a href="logout.php">Uitloggen</a>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div>
                <a href="login.php" class="links account">Inloggen</a>
            </div>
        <?php endif; ?>
    </nav>
    <div class="statistic">
        <h1>Snelle statistieken</h1>
        <p>Aantal producten: <?= $productcount ?></p>
        <p>Aantal accounts: <?= $accountcount ?></p>
        <h3 class="notifymsg">Navigeer naar de pagina's in de navbar</h3>
    </div>
</body>

</html>