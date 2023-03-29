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
    <title>User management</title>
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
            <a href="addproduct.php" class="links active">Add product</a>
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
    <div class="tablediv">
        <form action="add.php" method="post" enctype="multipart/form-data" class="stylish">
            <table class="noborder">
                <tr>
                    <th>Itemnaam</th>
                    <td><input type="text" name="itemnaam" id="itemnaam"></td>
                </tr>
                <tr>
                    <th>Foto</th>
                    <td><input type="file" name="foto" id="foto"></td>
                </tr>
                <tr>
                    <th>Game</th>
                    <td><input type="text" name="game" id="game"></td>
                </tr>
                <tr>
                    <th>Prijs</th>
                    <td><input type="text" name="prijs" id="prijs"></td>
                </tr>
                <tr>
                    <th>Voorraad</th>
                    <td><input type="number" name="voorraad" id="voorraad"></td>
                </tr>
                <tr>
                    <th>Beschrijving</th>
                    <td><input type="text" name="beschrijving" id="beschrijving"></td>
                </tr>
                <tr>
                    <th></th>
                    <td><input type="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>