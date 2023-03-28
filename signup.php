<?php

require "connect.php";

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();
$found = 0;
$success = 0;

if (isset($_POST["register"])) {
    $hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $sql = "SELECT * FROM userdata WHERE username=?;";
    $userexists = $pdo->prepare($sql);
    $userexists->execute([$_POST["username"]]);
    foreach ($userexists as $u) {
        if ($u["username"] == $_POST["username"]) {
            $found = 1;
        }
    }
    if ($found == 0) {
        $sql = "INSERT INTO userdata (username, password) VALUES (?, ?);";
        $pdo->prepare($sql)->execute([$_POST["username"], $hash]);
        $success = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreer</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require "nav.php" ?>
    <div>
        <a href="index.php">
            <h1 class="title">Merchandise</h1>
        </a>
    </div>
    <div class="linkdiv">
        <div class="dropdown">
            <button class="dropbtn">Gamecollecties
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <?php foreach ($games as $game) : ?>
                    <a href="collection.php?game=<?= $game["game"] ?>"><?= $game["game"] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="" class="links">Over ons</a>
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
    <div class="login">
        <div>
            <h1>Registreer</h1>
        </div>
        <div>
            <form action="" method="post" class="loginform">
                <label for="username" class="db">Gebruikersnaam</label>
                <input type="text" name="username" id="username" class="db">
                <label for="password" class="db">Wachtwoord</label>
                <input type="password" name="password" id="password" class="db">
                <input type="submit" value="register" name="register">
            </form>
        </div>
        <div>
            <?php if ($found == 1) : ?>
                <p class="errormsg">Er is al een gebruiker met deze naam geregistreerd</p>
            <?php endif; ?>
            <?php if ($success == 1) : ?>
                <p class="successmsg">Gelukt!</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>