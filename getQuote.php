<?php
include "protected/connect.php";
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 19/08/2018
 * Time: 12:01
 */

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json");

include_once 'protected/connect.php';

$limit = 1;
$result = array();

if (isset($_GET["amount"]) && is_numeric($_GET["amount"]) && $_GET["amount"] > 1) {
    if ($_GET["amount"] > 50) {
        $limit = 50;
    } else {
        $limit = $_GET["amount"];
    }
}
//$result = $conn->query('SELECT * FROM discord ORDER BY RAND() LIMIT 1'.$limit);
if (isset($_GET["search"])) {
    $accepted = 1;
    if (isset($_GET["filter"])) {
        if ($_GET["filter"] == "pending") {
            $accepted = 0;
        }
    }
    $pattern = "%{$_GET["search"]}%";
    if ($stmt = $conn->prepare("SELECT id,quote,user_id FROM discord WHERE user_id LIKE ? AND accepted=?")) {
        $stmt->bind_param("si", $pattern, $accepted);
        $stmt->execute();
        $stmt->bind_result($id, $quote, $user_id);
        while ($stmt->fetch()) {
            if (empty($quote)) {
                echo '{"error": "No quotes found to fetch."}';
                return;
            };
            $tempResult = array();
            $tempResult["id"] = $id;
            $tempResult["quote"] = $quote;
            $tempResult["user_id"] = $user_id;
            $result[] = $tempResult;
        }
    } else {
        echo '{"error": "No quotes found to fetch."}';
        return;
    }
} else if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

    if ($stmt = $conn->prepare('SELECT id,quote,user_id, accepted FROM discord where id=?')) {
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($id, $quote, $user_id, $accepted);
        $stmt->fetch();
        if (empty($quote)) {
            echo '{"error": "No quotes found to fetch."}';
            return;
        };
        if ($accepted) {
            $result["id"] = $id;
            $result["quote"] = $quote;
            $result["user_id"] = $user_id;
        }
    } else {
        echo '{"error": "No quotes found to fetch."}';
        return;
    }
} else {
    $query = $conn->query('SELECT id,quote,user_id FROM discord WHERE accepted=1 ORDER BY RAND(RAND(RAND(RAND(RAND(RAND(RAND(RAND()*1000)*1000)*1000)*1000)*1000)*1000)*1000) LIMIT 1');
    $resultArray = $query->fetch_row();
    if (empty($resultArray)) {
        echo '{"error": "No quotes found to fetch."}';
        return;
    }
    $result["id"] = $resultArray[0];
    $result["quote"] = $resultArray[1];
    $result["user_id"] = $resultArray[2];
}
if (empty($result)) {
    echo '{"error": "No quotes found to fetch."}';
} else {
    echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
