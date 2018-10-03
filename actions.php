<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 9/16/2018
 * Time: 12:33 AM
 */
session_start();
if (isset($_GET["data"], $_GET["id"]) && isset($_SESSION["username"])) {
    include_once "includes/connect.php";
    $ch = new ConnectionHandler();
    $ch->connectToUsers();
    $conn = $ch->getConnection();
    if ($_GET["data"] == "accept") {
        if ($stmt = $conn->prepare("UPDATE discord SET accepted = 1 WHERE id=?")) {
            $stmt->bind_param("i", $_GET["id"]);
            $stmt->execute();
            header("Location: admin.php");
        } else {
            header("Refresh:5; url=admin.php", true, 303);
            echo "Unable to accept quote!";
        }
    } else if ($_GET["data"] == "deny") {
        if ($stmt = $conn->prepare("DELETE FROM discord WHERE id=?")) {
            $stmt->bind_param("i", $_GET["id"]);
            $stmt->execute();
            header("Location: admin.php");
        } else {
            header("Refresh:5; url=admin.php", true, 303);
            echo "Unable to deny quote!";
        }
    }
} else {
    echo "Unauthorised Access";
}