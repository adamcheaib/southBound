<?php

function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}

$method = $_SERVER["REQUEST_METHOD"];
$receivedData;

if ($method == "POST") {

    $receivedData = json_decode(file_get_contents("php://input"), true);

    if (isset($receivedData["page"])) {
        function uploadCarsPage() {
            return '
            <form action="../backend-data/requests.php">
                <!--
                    Year,   Select
                    Make,   Select
                    Model,  Select
                    Miles   Select
                    
                    Color,  Select
                    Desc.   Text
                    Price   Text
    
                 -->
    
                <div id="uploadContainer">
                    <span>Year</span>
                    <input type="text" name="carYear" placeholder="Enter Year">
    
                    <span>Make</span>
                    <input type="text" name="carMake" placeholder="Enter Make">
    
                    <span>Model</span>
                    <input type="text" name="carModel" placeholder="Enter Model">
    
                    <span>Miles</span>
                    <input type="text" name="carMiles" placeholder="Enter Miles">
    
                    <span>Color</span>
                    <input type="text" name="carColor" placeholder="Enter Color">
    
    
                    <span id="carDescTitle">Description</span>
                    <textarea name="carDescription" id="carDescription" cols="30" rows="10"></textarea>
    
                    <span id="carPrice">Car Price</span>
                    <input type="text" name="carPrice" placeholder="Enter Price">
    
                    <div id="uploadImages">
                        <span>Images</span>
                        <br>
                    </div>
    
                    <div id="moreImagesButton">Add more images</div>
    
                    <button type="submit">Upload Car</button>
                </div>
            </form>';
        }
    
        function inventoryPage() {
            return '
            <h1>Hello World</h1>';
        }
    
        if ($receivedData["username"] == "test") {
            sendJSON(["message" => uploadCarsPage()]);
        }

    }


    // Deals with uploading car images and information.
    $allCars = json_decode(file_get_contents("../backend-data/cars.json"), true);
    $carInformation = [];
    $newCarId = 0;

    if ($allCars != null) {
        foreach($allCars as $car) {
            if ($newCarId <= $car["id"]) {
                $newCarId = $car["id"] + 1;
            }
        }
    }

    $carInformation["id"] = $newCarId;
    
    function moveImages($imageFile, $index) {
        // sendJSON(pathinfo($imageFile["full_path"], PATHINFO_EXTENSION));

        if (!getimagesize($imageFile["tmp_name"])) {
            $message = ["response" => "Wrong type of file! Only JPG/JPEG/PNG files are accepted!"];
            sendJSON($message, 400);
        }

        $carFolderName = $_POST["carMake"] . " " . $_POST["carModel"] . " " . $_POST["carYear"];
        $source = $imageFile["tmp_name"];
    
        if (!file_exists("../carImages/$carFolderName")) {
            mkdir("../carImages/$carFolderName");
            $destination = "../carImages/$carFolderName/" . "image-" . $index;
        } else {
            $tmpCarFolderName = $carFolderName . " " . time();
            mkdir("../carImages/$tmpCarFolderName");
            $destination = "../carImages/$tmpCarFolderName/" . "image-" . $index;
        }


        move_uploaded_file($source, $destination);
        return $destination;
    }

    foreach($_POST as $key => $info) {
        $carInformation[$key] = $info;
    }

    $index = 1;
    
    foreach($_FILES as $image) {
        $carInformation["images"][] = moveImages($image, $index);
        $index++;
    }

    $allCars[] = $carInformation;
    file_put_contents("../backend-data/cars.json", json_encode($allCars, JSON_PRETTY_PRINT));
    sendJSON($allCars);
}

?>