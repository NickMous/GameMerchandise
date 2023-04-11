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
    <div class="login">
        <div>
            <h1>Registreer</h1>
        </div>
        <div>
            <form method="post" class="loginform">
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