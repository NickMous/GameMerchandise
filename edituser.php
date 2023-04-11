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

$sql = "SELECT * FROM userdata WHERE id=?;";
$userlist = $pdo->prepare($sql);
$userlist->execute([$_GET["id"]]);
$user = $userlist->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker bewerken</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="topnav" id="myTopnav">
        <div>
            <a href="index.php">
                <h1 class="title">Merchandise</h1>
            </a>
        </div>
        <div class="linkdiv">
            <a href="manageusers.php" class="links active">Users</a>
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
    <div class="tablediv noborder">
        <form action="edituserdone.php" method="post" enctype="multipart/form-data">
            <input type="number" name="id" id="id" class="invisible" value="<?= $_GET["id"] ?>">
            <table>
                <tr>
                    <td>Gebruikersnaam</td>
                    <td><input type="text" name="username" id="username" value="<?= $user["username"] ?>"></td>
                </tr>
                <tr>
                    <td>Wachtwoord</td>
                    <td><input type="password" name="password" id="pwd"></td>
                </tr>
                <tr>
                    <td>Profielfoto</td>
                    <td><input type="file" name="foto" id="foto" value="<?= $user["pfp"] ?>"></td>
                </tr>
                <tr>
                    <td>Admin</td>
                    <td><input type="checkbox" name="admin" id="admin" 
                    <?php if ($user["admin"] == "yes") {
                        echo "checked";
                    } ?>></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Wijzig"></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>