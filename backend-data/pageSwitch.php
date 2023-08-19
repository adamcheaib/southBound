<?php

function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $allCars = json_decode(file_get_contents(("./cars.json")), true);
    sendJSON($allCars);
} else {
    $message = ["response" => "Invalid request method!"];
    sendJSON($message, 400);
}

?>