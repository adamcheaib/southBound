<?php

require_once("./vendor/autoload.php");
\Tinify\setKey("DVPWhMk7BP81Y3BK98qQ68Prc4nt8H50");


if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    
function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}

// Checks if the file uploaded is an image.
foreach($_FILES as $imageFile) {
$imageType = $imageFile["type"];
if ($imageType != "image/png" and $imageType != "image/jpg" and $imageType != "image/jpeg" and $imageType != "image/webp") sendJSON(["response" => "Invalid type of image!"], 400);}


foreach ($_POST as $key => $info) {
    if ($info == " " or "") sendJSON(["response" => "Missing information!"], 400);
}

// This section is to control the cars and their IDs.
$allCars = json_decode(file_get_contents("../backend-data/cars.json"), true); // Fetches all the cars in the database.
$car = [];
$newCarId = 0;

// Increments the new ID for the new car.
if ($allCars != null) {
    foreach($allCars as $car) {
        if ($newCarId <= $car["id"]) {
            $newCarId = $car["id"] + 1;
        }
    }
}

// Assigns the newly created ID to the new car.
$car["id"] = $newCarId;

// Initializes the images array because it is loading images from the car above it in the database.
$car["images"] = [];
$car["frontpageImages"] = [];

// Assigns all the information for the car.
foreach ($_POST as $key => $info) {
    $car[$key] = $info;
}


// Creates the folder name for the car.
$carFolderName = $_POST["carMake"] . "-" . $_POST["carModel"] . "-" . $_POST["carYear"] . "-" . $_POST["carColor"];
$carParentFolder = "../carImages/$carFolderName";

// Creates the folder if it does not exist with the name given above.
if (!file_exists("../carImages/$carFolderName")) {
    mkdir($carParentFolder);
} else {
    $carParentFolder = $carFolderName . time();
    mkdir($carParentFolder);
}

    
foreach($_FILES as $key => $image) {
    $extension = pathinfo($image["full_path"], PATHINFO_EXTENSION);
    $tmpName = $image["tmp_name"];

    
    // Path for the admin page to save the images.
    $adminPath = "../carImages/$carParentFolder/$key.$extension";
    // Path for the frontpage in order to display the images.
    $frontpagePath = "./carImages/$carFolderName/$key.$extension";

    // Checks if the image is larger than 2MB.
    if ($image["size"] > 2000000) { // This is in bytes
        $source = \Tinify\fromFile($tmpName);
        $source->toFile("../carImages/$carParentFolder/$key.$extension");
    } else {
        // CONTINUE HERE
        move_uploaded_file($tmpName, "../carImages/$carParentFolder/$key.$extension");
    }
    
    $car["images"][] = "../carImages/$carParentFolder/$key.$extension";
    $car["frontpageImages"][] = "./carImages/$carFolderName/$key.$extension";
}

$car["directory"] = $carParentFolder;


// Adds the car to the array of cars.
$allCars[] = $car;

// Uploads the updated array of cars to the database.
file_put_contents("../backend-data/cars.json", json_encode($allCars, JSON_PRETTY_PRINT));
sendJSON("Car uploaded successfully!");
} else {
    sendJSON(["response" => "Invalid request"], 400);
}


?>