<?php

// Switch so that the innerHTML that is sent sends the head for each page as well. This is so that I can switch between different Javascript files!

function sendJSON($message, $httpResponse = 200) {
    header("application/json");
    http_response_code($httpResponse);
    echo json_encode($message);
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$receivedData = $_GET["pageid"];
$innerHTML = '

<main id="wrapper">

<div id="welcomeSquare">
    <div id="introSquare">
        <h2>Make a change</h2>
        <h1>South Bound Auto Sales</h1>
        <h2>Buy your new car from us</h2>
    </div>
</div>

<div id="latestCarsContainer">
    <h1>New Arrivals</h1>
    <div id="latestCars">
        <a href="">
            <img src="" alt="">
        </a>
        <a href="">
            <img src="" alt="">
        </a>
        <a href="">
            <img src="" alt="">
        </a>
    </div>
    <a href="#">Click here for the full inventory</a>
</div>

</main>

<dialog></dialog>
<script src="./frontpage.js"></script>
<script src="./index.js"></script>';

$cssFile = "./css/frontpage.css";

if (isset($receivedData)) {
    switch ($receivedData) {
        case 2:
            $innerHTML = '
            <h1>Hello world</h1>
            <dialog></dialog>
            <script src="./index.js"></script>';
            
            $cssFile = "./css/inventory.css";
            break;
            case "3":
                $innerHTML = 'Contact HTML
                <dialog></dialog>
                <script src="./index.js"></script>';
                $cssFile = "./css/contact.css";
            break;
        default:
            $innerHTML;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>South Bound Auto Sales | HOME</title>
    <link rel="stylesheet" href="./mainpage.css">
    <link rel="stylesheet" href=<?php echo $cssFile; ?>>

</head>

<body>
    <nav id="mainNav">
        <img src="./siteMedia/logoSample.png" alt="">
        <menu>
            <a href="./" id="homeButton">HOME</a>

            <div page-id="2">INVENTORY</div>

            <div page-id="3">CONTACT</div>
        </menu>
    </nav>
    <?php echo $innerHTML ?>
</body>

</html>