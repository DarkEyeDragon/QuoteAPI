<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 9/15/2018
 * Time: 10:38 PM
 */
session_start();
if (!isset($_SESSION["username"])) {
    if (isset($_POST["username"], $_POST["password"])) {
        //$passHash = password_hash($_POST["password"], PASSWORD_BCRYPT);
        include_once 'protected/connect.php';
        if ($stmt = $conn->prepare('SELECT username,password,admin FROM users where username=?')) {
            $stmt->bind_param("s", $_POST["username"]);
            $stmt->execute();
            $stmt->bind_result($username, $password, $admin);
            $stmt->fetch();
            if ($admin && password_verify($_POST["password"], $password)) {
                $_SESSION["username"] = $_POST["username"];
                header("Location: admin.php");
            }
        } else {
            echo $conn->error;
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
        <link href="https://fonts.googleapis.com/css?family=Lato:900" rel="stylesheet">

    </head>
    <div class="wrapper">
        <h3>Login</h3>
        <form action="login.php" method="post">
            <fieldset>
                <p>Username</p>
                <input type="text" required placeholder="Type your username" name="username">
            </fieldset>
            <fieldset>
                <p>Password</p>
                <input type="password" required placeholder="Type your password" name="password">
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