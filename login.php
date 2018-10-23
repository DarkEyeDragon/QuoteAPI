<?php
include "includes/DBController.php";
session_start();
if (!isset($_SESSION["username"])) {
    if (isset($_POST["username"], $_POST["password"])) {
        //$passHash = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $controller = new DBController();
        if ($controller->validateUser($_POST["username"], $_POST["password"])) {
            $_SESSION["username"] = $_POST["username"];
            header("Location: admin.php");
        }
    }
    ?>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin portal</title>
        <meta name="description" content="Admin portal">
        <meta name="author" content="DarkEyeDragon">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Lato:900" rel="stylesheet">

    </head>
    <div class="wrapper">
        <h3>Login</h3>
        <form action="login.php" method="post">
            <fieldset>
                <input type="text" required placeholder="Username" name="username">
            </fieldset>
            <fieldset>
                <input type="password" required placeholder="Password" name="password">
            </fieldset>
            <input type="submit">
        </form>
    </div>
    </html>
    <?php
} else {
    header("Location: admin.php");
}

?>