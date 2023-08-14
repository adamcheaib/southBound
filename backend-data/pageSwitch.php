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
} else {

    if (!isset($_GET["pageid"])) {
        $message = ["response" => "Wrong parameter"];
        sendJSON($message, 400);
    }
    
    $receivedData = $_GET["pageid"];

    switch($receivedData) {
        case "2":
            $message = ["response" => "INVENTORY HTML HERE"];
            sendJSON($message);
            break;
        case "3":
            $message = ["response" => "CONTACT HTML HERE"];
            sendJSON($message);
            break;
    }
};
?>