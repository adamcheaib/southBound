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
                <textarea name="" id="carDescription" cols="30" rows="10"></textarea>

                <span id="carPrice">Car Price</span>
                <input type="text" placeholder="Enter Price">

                <div id="uploadImages">
                    <span>Images</span>
                    <br>
                    <div>
                        <input type="file" name="" id="">
                        <span class="removeImageButton">Remove</span>
                    </div>
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

?>