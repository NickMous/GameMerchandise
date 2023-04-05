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

$sql = "SELECT * FROM userdata;";
$userlist = $pdo->query($sql);
$userlist->execute();
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
    <div class="tablediv">
        <table>
            <thead>
                <th>Gebruikersnaam</th>
                <th>Profielfoto</th>
                <th>Bestandsnaam</th>
                <th>Admin</th>
                <th></th>
            </thead>
            <?php foreach ($userlist as $user) : ?>
                <tr>
                    <td><?= $user["username"] ?></td>
                    <td>
                        <img src="media/pfp/<?= $user["pfp"] ?>" alt="pfp if set" class="tableimg">
                    </td>
                    <td><?= $user["pfp"] ?></td>
                    <td><?= $user["admin"] ?></td>
                    <td>
                        <div class="editdiv">
                            <a href="edituser.php?id=<?= $user["id"] ?>" class="texthover">Bewerk gebruiker</a>
                            <a href="edituserdone.php?id=<?= $user["id"] ?>&remove='yes'" class="texthover">Verwijder gebruiker</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>