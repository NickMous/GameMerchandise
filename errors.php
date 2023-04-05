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
    <?php if ($_GET["error"] == "noimg") : ?>
        <p class="errormsg">Geen foto aangeleverd</p>
    <?php else : ?>
        <?php  if ($_GET["error"] == "toolarge") : ?>
        <p class="errormsg">De foto is te groot van bestandsgrootte</p>
        <?php else : ?>
            <?php if ($_GET["error"] == "notsupported") : ?>
            <p class="errormsg">Alleen JPG, PNG, JPEG en GIF zijn toegestaan</p>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>