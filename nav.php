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
        <div class="dropdown opened">
            <button class="dropbtn" id="collection">Gamecollecties
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <?php foreach ($games as $game) : ?>
                    <a href="collection.php?game=<?= $game["game"] ?>" id="<?= $game["game"] ?>"><?= $game["game"] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="aboutus.php" class="links" id="aboutus">Over ons</a>
    </div>
    <?php if ($logged) : ?>
        <div class="linkdiv account left">
            <div class="dropdown">
                <button class="links scicon dropbtn">
                    <img src="media/extra/cart-shopping-solid.svg" alt="shoppingcart" class="icon">
                </button>
                <div class="dropdown-content sccontent">
                    <div class="scelem">
                        <p class="noitem">Er is geen item in je winkelwagen...</p>
                    </div>
                </div>
            </div>
            <?php if (isset($user["pfp"])) : ?>
                <img src="media/pfp/<?= $user["pfp"] ?>" alt="">
            <?php endif; ?>
            <div class="dropdown">
                <button class="dropbtn" id="pf"><?= $name ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content accountcontent">
                    <a href="profile.php" id="profile">Mijn profiel</a>
                    <a href="logout.php" id="logout">Uitloggen</a>
                    <?php if ($user["admin"] == "yes") : ?>
                        <a href="admin.php" class="admin">Admin</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="left">
            <div class="dropdown">
                <button class="links scicon dropbtn">
                    <img src="media/extra/cart-shopping-solid.svg" alt="shoppingcart" class="icon">
                </button>
                <div class="dropdown-content sccontent">
                    <div class="scelem">
                        <img src="media/itemimg/badtoy.jpg" alt="toy">
                        <div>
                            <h4>toy</h4>
                            <p>4.99</p>
                            <p>In winkelwagen: 5</p>
                        </div>
                        <div class="scbtns">
                            <div>
                                <button>+</button>
                                <button>-</button>
                            </div>
                            <button>verwijder</button>
                        </div>
                    </div>
                </div>
            </div>
            <a href="login.php" class="links account" id="login">Inloggen</a>
        </div>
    <?php endif; ?>
</nav>