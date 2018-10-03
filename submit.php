<?php
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json");
include "includes/DBController.php";

$DBController = new DBController();


if (isset($_GET["quote"], $_GET["user_id"])) {
    var_dump($DBController);
    $DBController->insertQuote($_GET["quote"], $_GET["user_id"]);
} else {
    constructResponse(false);
}
function constructResponse($success)
{
    if (isset($_GET["responseType"])) {
        if ($_GET["responseType"] == "json") {
            if ($success)
                echo '{"response": "200"}';
            else
                echo '{"response": "400"}';
        } else {
            if ($success)
                http_response_code(200);
            else
                http_response_code(400);
        }

    } else {
        if ($success)
            http_response_code(200);
        else
            http_response_code(400);
    }
}