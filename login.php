<?php

require "connect.php";

$sql = "SELECT game FROM gamemerch GROUP BY game;";
$games = $pdo->query($sql)->fetchAll();

$error = 0;

if (isset($_POST["login"])) {
    $sql = "SELECT * FROM userdata WHERE username=?;";
    $users = $pdo->prepare($sql);
    $users->execute([$_POST["username"]]);
    foreach ($users as $user) {
        if ($user["username"] == $_POST["username"]) {
            if (password_verify($_POST["password"], $user["password"])) {
                $_SESSION["logged"] = true;
                $_SESSION["username"] = $_POST["username"];
                header("Location: index.php");
            } else {
                $error = 1;
            }
        } else {
            $error = 1;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require "nav.php" ?>
    <div class="login">
        <div>
            <h1>Log in</h1>
        </div>
        <div>
            <form action="" method="post" class="loginform">
                <label for="username" class="db">Gebruikersnaam</label>
                <input type="text" name="username" id="username" class="db">
                <label for="password" class="db">Wachtwoord</label>
                <input type="password" name="password" id="password" class="db">
                <input type="submit" value="login" name="login">
            </form>
        </div>
        <div>
            <?php if ($error == 1) : ?>
                <p class="errormsg">De gebruikersnaam of wachtwoord is fout</p>
            <?php endif; ?>
        </div>
        <div>
            <p>Nog geen account? <a href="signup.php">Registreer je!</a></p>
        </div>
    </div>
</body>

</html>