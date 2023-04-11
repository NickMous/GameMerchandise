<?php

require "connect.php";

// checks if user wants to remove or add

if (isset($_GET["remove"])) {
    $sql = "SELECT * FROM gamemerch WHERE id=?";
    $user = $pdo->prepare($sql);
    $user->execute([$_GET["id"]]);
    $game = $user->fetch();
    unlink("media/itemimg/" . $game["foto"]);
    $sql = "DELETE FROM gamemerch WHERE id=?";
    $pdo->prepare($sql)->execute([$_GET["id"]]);
    header("Location: productlist.php");
} else if ($_FILES["foto"]["name"] != "") {
    $sql = "SELECT * FROM gamemerch WHERE id=?";
    $user = $pdo->prepare($sql);
    $user->execute([$_POST["id"]]);
    $game = $user->fetch();
    unlink("media/itemimg/" . $game["foto"]);

    $target_dir = "media/itemimg/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        header("Location: errors.php?error=noimg");
        $uploadOk = 0;
    }

    // Check if file already exists
    while (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $_FILES["foto"]["name"] = 0 . $_FILES["foto"]["name"];
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    }

    // Check file size
    if ($_FILES["foto"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        header("Location: errors.php?error=toolarge");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: errors.php?error=notsupported");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $sql = "UPDATE gamemerch SET naam=?, game=?, prijs=?, voorraad=?, beschrijving=?, foto=? WHERE id=?;";
    $pdo->prepare($sql)->execute([$_POST["itemnaam"], $_POST["game"], $_POST["prijs"], $_POST["voorraad"], $_POST["beschrijving"], $_FILES["foto"]["name"], $_POST["id"]]);
    header("Location: productlist.php");
} else {
    $sql = "UPDATE gamemerch SET naam=?, game=?, prijs=?, voorraad=?, beschrijving=? WHERE id=?;";
    $pdo->prepare($sql)->execute([$_POST["itemnaam"], $_POST["game"], $_POST["prijs"], $_POST["voorraad"], $_POST["beschrijving"], $_POST["id"]]);
    header("Location: productlist.php");
}
