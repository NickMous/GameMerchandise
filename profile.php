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

$sql = "SELECT * FROM userdata WHERE id=?;";
$userlist = $pdo->prepare($sql);
$userlist->execute([$_SESSION["id"]]);
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
    <script src="script.js" defer></script>
    <style>
        #pf {
            padding: 14px 16px;
            background-color: #00695C;
        }
        #profile {
            padding: 14px 16px;
            background-color: #00695C;
            color: white;
        }
    </style>
</head>

<body>
    <?php require "nav.php" ?>
    <div class="tablediv noborder">
        <form action="editprofiledone.php" method="post" enctype="multipart/form-data">
            <input type="number" name="id" id="id" class="invisible" value="<?= $_SESSION["id"] ?>">
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
                    <td></td>
                    <td><input type="submit" value="Wijzig"></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>