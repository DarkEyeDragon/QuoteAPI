<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 9/14/2018
 * Time: 4:42 PM
 */
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json");
include "protected/connect.php";
if (isset($_GET["quote"], $_GET["user_id"])) {
    if ($stmt = $conn->prepare('INSERT INTO discord (quote, user_id) VALUES (?,?)')) {
        $message = mysqli_real_escape_string($conn, $_GET["quote"]);
        $stmt->bind_param("ss", $message, $_GET["user_id"]);
        $stmt->execute();
        constructResponse(true);
    } else {
        $success = false;
        constructResponse(false);
    }
    $stmt->close();
} else {
    constructResponse(false);
}
$conn->close();
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