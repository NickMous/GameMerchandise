<?php

if ($_SESSION["logged"]) {
    $sql = "SELECT * FROM userdata WHERE username = ?;";
    $users = $pdo->prepare($sql);
    $users->execute([$_SESSION["username"]]);
    foreach ($users as $u) {
        $user = $u;
    }
    $name = $_SESSION["username"];
    $logged = true;
} else {
    $name = "Account";
    $logged = false;
}
?>
<nav class="topnav" id="myTopnav">
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
</nav>