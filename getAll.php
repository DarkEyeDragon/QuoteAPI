<?php
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json");
include_once "protected/connect.php";

//TODO MAKE Object Oriented
if (isset($_GET["filter"])) {
    if ($_GET["filter"] == "accepted") {


        $result = $conn->query("SELECT * FROM discord WHERE accepted=1");
    } else if ($_GET["filter"] == "pending") {
        $result = $conn->query("SELECT * FROM discord WHERE accepted=0");
    }
} else {
    $result = $conn->query("SELECT * FROM discord");
}


//Initialize array variable
$dbdata = array();

//Fetch into associative array
while ($row = $result->fetch_assoc()) {
    $dbdata[] = $row;
}

//Print array in JSON format
echo json_encode($dbdata, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);