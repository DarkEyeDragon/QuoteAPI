<?php
session_start();
include "includes/DBController.php";
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
}
$controller = new DBController();

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--<script src="js/editor.js"></script>-->
</head>
<body>
<div id="infoSection">
    <p id="infoText"></p>
</div>
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
        <h2>Pending</h2>
        <?php
        echo "<p>" . $controller->getPending() . "</p>";
        ?>
    </div>

    <div class="stats-panel">
        <h2>Accepted</h2>
        <?php
        echo "<p>" . $controller->getAccepted() . "</p>";
        ?>
    </div>
    <div class="stats-panel">
        <h2>Total</h2>
        <?php
        echo "<p>" . $controller->getTotal() . "</p>";
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
                <th class="table_date">Date</th>
                <th class="table_action">Action</th>
            </tr>
            <tr>
                <?php
                $result = $controller->getQuote(50, 0);
                foreach ($result as $value) {
                    echo "<tr>";
                    $count = 0;
                    $id = 0;
                    foreach ($value as $finalValue) {
                        if ($count == 0) {
                            $id = $finalValue;
                        }
                        $count++;
                        echo "<td>" . $finalValue . "</td>";
                    }
                    echo "<td class='action'><a href='actions.php?data=accept&id=" . $id . "'><img class='icon' src='images/icons/check.png'></a> <a href='actions.php?data=deny&id=" . $id . "'><img class='icon' src='images/icons/deny.png'></a></td>";
                    echo "</tr>";
                }
                ?>
            </tr>
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
            $result = $controller->getQuote(50, 1);
            foreach ($result as $value) {
                echo "<tr>";
                foreach ($value as $finalValue) {
                    echo "<td>" . $finalValue . "</td>";
                }
                echo "<td class='action'><a href='#'><img class='icon' src='images/icons/delete.png'></a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>
<div class="container">
    <div class="content">
        <h2>Add quote</h2>
        <form id="form" method="get" action="submit.php">
            <fieldset>
                <label>Quote</label>
                <input id="quote_input" required type="text" placeholder="Quote" name="quote">
            </fieldset>
            <fieldset>
                <label>Author</label>
                <input id="user_id_input" required type="text" placeholder="Author" name="user_id">
            </fieldset>
            <input type="submit">
        </form>
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
<script src="js/ajax.js"></script>
</body>
</html>
