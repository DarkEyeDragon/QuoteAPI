<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quotes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

// Check connection
if ($conn->connect_error) {
    die('{"error": "Unable to connect to database!"}');
}