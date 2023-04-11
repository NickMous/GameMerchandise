<?php

require "connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen</title>
    <link rel="stylesheet" href="style.css">
    <script src="scripts/setelements.js" defer></script>
</head>

<body>
    <?php require "nav.php" ?>
    <div class="cscontent">
        <div class="cselem">
            <img src="media/itemimg/badtoy.jpg" alt="badtoy">
            <div>
                <h4>ai</h4>
                <p>€<span>2.99</span></p>
                <p>In winkelwagen: 3</p>
                <p>Totaal: €8.97</p>
            </div>
            <div class="csbtns">
                <div>
                    <button>+</button>
                    <button>-</button>
                </div>
                <button>verwijder</button>
            </div>
        </div>
    </div>
</body>

</html>