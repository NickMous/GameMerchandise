<?php

require "connect.php";

// checks if user wants to remove or add

if (isset($_GET["remove"])) {
    $sql = "SELECT * FROM userdata WHERE id=?";
    $user = $pdo->prepare($sql);
    $user->execute([$_GET["id"]]);
    $game = $user->fetch();
    unlink("media/pfp/" . $game["foto"]);
    $sql = "DELETE FROM userdata WHERE id=?";
    $pdo->prepare($sql)->execute([$_GET["id"]]);
}

if ($_FILES["foto"]["name"] != "") {
    $sql = "SELECT * FROM userdata WHERE id=?";
    $user = $pdo->prepare($sql);
    $user->execute([$_POST["id"]]);
    $game = $user->fetch();
    unlink("media/pfp/" . $game["pfp"]);

    $target_dir = "media/pfp/";
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
    $sql = "UPDATE userdata SET username=?, pfp=? WHERE id=?;";
    $pdo->prepare($sql)->execute([$_POST["username"], $_FILES["foto"]["name"], $_POST["id"]]);
} else {
    $sql = "UPDATE userdata SET username=? WHERE id=?;";
    $pdo->prepare($sql)->execute([$_POST["username"], $_POST["id"]]);
}

if ($_POST["password"] != "") {
    $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $sql = "UPDATE userdata SET password=? WHERE id=?;";
    $pdo->prepare($sql)->execute([$pass, $_POST["id"]]);
}
$_SESSION["username"] = $_POST["username"];

header("Location: profile.php");