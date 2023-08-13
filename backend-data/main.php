<?php

function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method != "GET") {
    $message = ["response" => "Method not allowed!"];
    sendJSON($message, 405);
};
?>