<?php

function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}

$method = $_SERVER["REQUEST_METHOD"];
$allCars = json_decode(file_get_contents("../backend-data/cars.json"), true);

$year;
$make;
$model;
$miles;
$color;
$description;
$price;
$images;
$firstImage;

if ($method == "GET") {
    $receivedData = $_GET["car"];
    foreach ($allCars as $car) {
        if ($receivedData == $car["id"]) {
            $year = $car["carYear"];
            $make = $car["carMake"];
            $model = $car["carModel"];
            $miles = $car["carMiles"];
            $color = $car["carColor"];
            $description = $car["carDescription"];
            $price = $car["carPrice"];
            $images = $car["frontpageImages"];
            $firstImage = $images[0];
        }
    }    
    

} else {
    $message = ["response" => "Invalid request type!"];
    sendJSON($message, 405);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../displaycar/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>South Bound Auto Sales | Good Quality, Used, Refurbished Cars</title>
    <link rel="stylesheet" href="../mainpage.css">
    <link rel="stylesheet" href="./displaycars.css">
    <script defer src="../index.js"></script>
    <script defer src="./displaycars.js"></script>
</head>

<body>
    <nav id="mainNav">
        <img src="../siteMedia/logo-removebg-preview.png" alt="">
        <menu>
            <a href="../" id="homeButton">HOME</a>

            <div page-id="2">INVENTORY</div>

            <div page-id="3">CONTACT</div>
        </menu>

        <div id="hamburgerMenu">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>

    <div id="wrapper">
        <div id="image-and-details">
            <div id="details">
                <?php
                echo "<h2>$color $year $make $model</h2>";
                echo "<h3>$miles miles</h3>";
                echo "<p>$description</p>";
                echo "<span>Price: $$price</span>";
                ?>
            </div>
            <img id="image" src='<?php echo "." . $firstImage ?>'>
        </div>

        <div id="imagesContainer">
            <?php
            for ($i = 1; $i < count($images); $i++) {
                $picturePath = "." . $images[$i];
                echo "<img src='$picturePath'>";
            }
            ?>
        </div>
    </div>

    <dialog></dialog>
</body>

</html>