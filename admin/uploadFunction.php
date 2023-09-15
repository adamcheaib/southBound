<?php

function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}
function uploadImagesThroughArray($arr, $index, $carInformation) {
    // Check if all of the files are images!
    foreach($arr as $imageFile) {
        if (!getimagesize($imageFile)["tmp_name"]) {
            $message = ["response" => "Wrong type of file! Only JPG/JPEG/PNG are allowed!"];
            sendJSON($message, 400);
        }
    }

    // Creates the folder name for the car.
    $carFolderName = $_POST["carMake"] . "-" . $_POST["carModel"] . "-" . $_POST["carYear"] . "-" . $_POST["carColor"];

    // Creates two separate directories if the same exact car exists!
    if (!file_exists("../carImages/$carFolderName")) {
        $carFolder = "../carImages/$carFolderName";
        mkdir($carFolder);
        // What the image will be saved as. This will be passed as an argument for the imagecompression function!
        $fileDestination = "$carFolder/image-";
    }
}
?>