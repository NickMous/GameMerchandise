<?php

require "connect.php";

// If the user is not logged in or not an admin, they should be redirected to the homepage

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

$sql = "SELECT * FROM gamemerch;";
$games = $pdo->query($sql);
$games->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>
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
            <a href="productlist.php" class="links active">Products</a>
            <a href="addproduct.php" class="links">Add product</a>
        </div>
        <?php if ($logged) : ?>
            <div class="linkdiv account left">
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
            <div class="left">
                <a href="login.php" class="links account">Inloggen</a>
            </div>
        <?php endif; ?>
    </nav>
    <div class="tablediv">
        <table>
            <thead>
                <th>Itemnaam</th>
                <th>Itemfoto</th>
                <th>Bestandsnaam</th>
                <th>Game</th>
                <th>Prijs</th>
                <th>Voorraad</th>
                <th>Bescrijving</th>
                <th></th>
            </thead>
            <?php foreach ($games as $game) : ?>
                <tr>
                    <td><?= $game["naam"] ?></td>
                    <td>
                        <img src="media/itemimg/<?= $game["foto"] ?>" alt="img if set" class="tableimg">
                    </td>
                    <td><?= $game["foto"] ?></td>
                    <td><?= $game["game"] ?></td>
                    <td><?= $game["prijs"] ?></td>
                    <td><?= $game["voorraad"] ?></td>
                    <td><?= $game["beschrijving"] ?></td>
                    <td>
                        <div class="editdiv">
                            <a href="edit.php?id=<?= $game["id"] ?>" class="texthover">Bewerk product</a>
                            <a href="editdone.php?id=<?= $game["id"] ?>&remove='yes'" class="texthover">Verwijder product</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>