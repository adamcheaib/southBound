<?php
ini_set("display_errors", 1);

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

    if (isset($receivedData["username"]) and isset($receivedData["password"])) {
        if ($receivedData["username"] == "southbound" and $receivedData["password"] == "abouharbs") {
            $adminNav = '
            <nav id="adminMainMenu">
                <div>UPLOAD NEW CAR</div>
                <div>MANAGE INVENTORY</div>
            </nav>
            
            <main id="wrapper"></main>
            <dialog></dialog>';
    
            $message = ["html" => $adminNav, "scriptSource" => "./loggedOnAdmin.js"];
            sendJSON($message);
        } else {
            $message = ["response" => "Wrong username or password!"];
            sendJSON($message, 405);
        }
        
    }


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
                    <input type="text" name="carPrice" placeholder="Enter Price (Do not add Dollar sign)">
    
                    <div style="text-align: center;" id="uploadImages">
                        <span>Images</span>
                        <br>
                        <span style="font-size: 10px">The first image is the one used as a cover picture</span>
                    </div>
    
                    <div id="moreImagesButton">Add more images</div>
    
                    <button type="submit">Upload Car</button>
                </div>
            </form>';
        }
    
        function inventoryPage() {
            $allCars = json_decode(file_get_contents("../backend-data/cars.json"), true);
            return $allCars;
        }

        // Change so that the username is something that is stored in cookies!
        if ($receivedData["page"] == "uploadCars" and $receivedData["username"] == "test") {
            sendJSON(["message" => uploadCarsPage()]);
        }
        
        // Change so that the username is something that is stored in cookies!
        if ($receivedData["page"] == "inventory" and $receivedData["username"] == "test") {
            sendJSON(["message" => inventoryPage()]); 
        }
    }


    // Deals with uploading car images and information.
    $allCars = json_decode(file_get_contents("../backend-data/cars.json"), true);
    $carInformation = [];
    $newCarId = 0;

    foreach($_POST as $keyName => $info) {
        if ($_POST[$keyName] == "" or $_POST[$keyName] == " ") {
            $message = ["response" => "Please fill out all the fields before uploading!"];
            sendJSON($message, 405);
        }
    }

    if ($allCars != null) {
        foreach($allCars as $car) {
            if ($newCarId <= $car["id"]) {
                $newCarId = $car["id"] + 1;
            }
        }
    }

    $carInformation["id"] = $newCarId;

    function moveImagesThroughArray($arr, $index, $car) {
        // Checks if all of the files are images!
        foreach ($arr as $imageFile) {
            if (!getimagesize($imageFile["tmp_name"])) {
                $message = ["response" => "Wrong type of file! Only JPG/JPEG/PNG files are accepted!"];
                sendJSON($message, 400);
            }
        }

        $carFolderName = $_POST["carMake"] . " " . $_POST["carModel"] . " " . $_POST["carYear"] . " " . $_POST["carColor"];

        // If both of the exact same car exist!
        if (!file_exists("../carImages/$carFolderName")) {
            mkdir("../carImages/$carFolderName");
            $carFolder = "../carImages/$carFolderName";
            $fileDestination = "../carImages/$carFolderName/" . "image-";
            $mainPageFileDestination = "./carImages/$carFolderName/" . "image-";
        } else {
            $tmpCarFolderName = $carFolderName . " " . $car["id"] + 1;
            mkdir("../carImages/$tmpCarFolderName");
            $carFolder = "../carImages/$tmpCarFolderName";
            $fileDestination = "../carImages/$tmpCarFolderName/" . "image-";
            $mainPageFileDestination = "./carImages/$tmpCarFolderName/" . "image-";
        }        

        foreach ($arr as $imageFile) {
            $extension = pathinfo($imageFile["full_path"], PATHINFO_EXTENSION);
            $destination = $fileDestination . $index . "." . $extension;
            $source = $imageFile["tmp_name"];
            move_uploaded_file($source, $destination);
            $car["images"][] = $destination;
            $car["frontpageImages"][] = $mainPageFileDestination . $index . "." . $extension;
            $index++;
        }
        
        $car["directory"] = $carFolder;
        return $car;
    }
    
    foreach($_POST as $key => $info) {
        $carInformation[$key] = $info;
    }

    // moveImagesThroughArray($_FILES, 1, $carInformation);

    $allCars[] = moveImagesThroughArray($_FILES, 1, $carInformation);
    file_put_contents("../backend-data/cars.json", json_encode($allCars, JSON_PRETTY_PRINT));
    sendJSON($allCars);
}

if ($method == "DELETE") {
    $receivedData = json_decode(file_get_contents(("php://input")), true);
    if ($receivedData["username"] == "test") {
        $idToDelete = $receivedData["carId"];

        $allCars = json_decode(file_get_contents("../backend-data/cars.json"), true);

        for ($i = 0; $i < count($allCars); $i++) {
            if ($idToDelete == $allCars[$i]["id"]) {
                foreach ($allCars[$i]["images"] as $image) {
                    unlink($image);
                }
                rmdir($allCars[$i]["directory"]);
                array_splice($allCars, $i, 1);
                file_put_contents(("../backend-data/cars.json"), json_encode($allCars, JSON_PRETTY_PRINT));
                sendJSON($allCars);
            }
        }
    }
}

?>