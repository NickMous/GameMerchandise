<?php

require "connect.php"
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
    <?php require "nav.php" ?>
    <?php if ($_GET["error"] == "noimg") : ?>
        <p class="errormsg">Geen foto aangeleverd</p>
    <?php else : ?>
        <?php if ($_GET["error"] == "toolarge") : ?>
            <p class="errormsg">De foto is te groot van bestandsgrootte</p>
        <?php else : ?>
            <?php if ($_GET["error"] == "notsupported") : ?>
                <p class="errormsg">Alleen JPG, PNG, JPEG en GIF zijn toegestaan</p>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($_GET["error"] == "ordered") : ?>
        <p class="successmsg">Uw bestelling is verwerkt</p>
    <?php endif; ?>
    <?php if ($_GET["error"] == "wrongprice") : ?>
        <p class="errormsg">Geen geldige prijs. Voer een . in in plaats van een ,</p>
    <?php endif; ?>
</body>

</html>