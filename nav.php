<?php

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
}

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();
?>
<nav class="topnav" id="myTopnav">
    <div>
        <a href="index.php">
            <h1 class="title">Merchandise</h1>
        </a>
    </div>
    <div class="linkdiv">
        <div class="dropdown">
            <button class="dropbtn" id="collection">Gamecollecties
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <?php foreach ($games as $game) : ?>
                    <a href="collection.php?game=<?= $game["game"] ?>" id="<?= $game["game"] ?>"><?= $game["game"] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="" class="links" id="aboutus">Over ons</a>
    </div>
    <?php if ($logged) : ?>
        <div class="linkdiv account">
            <?php if (isset($user["pfp"])) : ?>
                <img src="media/pfp/<?= $user["pfp"] ?>" alt="">
            <?php endif; ?>
            <div class="dropdown">
                <button class="dropbtn" id="pf"><?= $name ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content accountcontent">
                    <a href="favs.php" id="fav">Favorieten</a>
                    <a href="profile.php" id="profile">Mijn profiel</a>
                    <a href="logout.php" id="logout">Uitloggen</a>
                    <?php if ($user["admin"] == "yes") : ?>
                        <a href="admin.php" class="admin">Admin</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div>
            <a href="login.php" class="links account" id="login">Inloggen</a>
        </div>
    <?php endif; ?>
</nav>