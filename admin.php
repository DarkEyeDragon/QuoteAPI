<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 9/14/2018
 * Time: 7:35 PM
 */
include_once 'protected/connect.php';
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin portal</title>
    <meta name="description" content="Admin portal">
    <meta name="author" content="DarkEyeDragon">
    <link rel="stylesheet" href="css/reset.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
}
?>
<body>
<div id="mySidenav" class="sidenav">
    <h3>Quote API</h3>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#">Dashboard</a>
    <a href="#">Accepted</a>
    <a href="#">Pending</a>
</div>
<h1>Admin Panel</h1>
<p style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</p>
<div class="stats">
    <div class="stats-panel">
        <h2>Accepted</h2>
        <?php
        if ($query = $conn->query('SELECT id FROM discord WHERE accepted=1')) {
            $row_count = $query->num_rows;
            echo "<p>" . $row_count . "</p>";
        } else {
            echo "<p>No result</p>";
        }
        ?>
    </div>

    <div class="stats-panel">
        <h2>Pending</h2>
        <?php
        if ($query = $conn->query('SELECT id FROM discord WHERE accepted=0')) {
            $row_count = $query->num_rows;
            echo "<p>" . $row_count . "</p>";
        } else {
            echo "<p>No result</p>";
        }
        ?>
    </div>
    <div class="stats-panel">
        <h2>Total</h2>
        <?php
        if ($query = $conn->query('SELECT id FROM discord')) {
            $row_count = $query->num_rows;
            echo "<p>" . $row_count . "</p>";
        } else {
            echo "<p>No result</p>";
        }
        ?>
    </div>
</div>
<div class="container">
    <div class="content">
        <h2>Pending quotes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Quote</th>
                <th>User</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php
            $query = $conn->query('SELECT * FROM discord WHERE accepted=0');
            while ($record = $query->fetch_row()) {
                echo "<tr><td>" . $record[0] . "</td>" . "<td>" . $record[1] . "</td>" . "<td>" . $record[2] . "</td>" . "<td>" . $record[4] . "</td><td><a href='actions.php?data=accept&id=" . $record[0] . "'>Accept</a> <a href='actions.php?data=deny&id=" . $record[0] . "'>Deny</a></td></tr>";
            }
            $query->close();
            ?>
        </table>
    </div>
</div>
<div class="container">
    <div class="content">
        <h2>Accepted quotes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Quote</th>
                <th>User</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php
            $query = $conn->query('SELECT * FROM discord WHERE accepted=1');
            while ($record = $query->fetch_row()) {
                echo "<tr><td>" . $record[0] . "</td>" . "<td>" . $record[1] . "</td>" . "<td>" . $record[2] . "</td>" . "<td>" . $record[4] . "</td><td><a href='actions.php?data=deny&id=" . $record[0] . "'>Remove</a></td></tr>";
            }
            $query->close();
            ?>
        </table>
    </div>
</div>
<p><a href="logout.php">Logout</a></p>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
</body>
</html>
