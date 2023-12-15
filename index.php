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
    <h1>Loading...</h1>
    <div id="latestCars">
    <p id="noCars">The inventory is currently empty. Please check again!</p>
        <a href="">
            <img src="" alt="Latest car 1">
        </a>
        <a href="">
            <img src="" alt="Latest car 2">
        </a>
        <a href="">
            <img src="" alt="Latest car 3">
        </a>
    </div>
    <a id="checkOutFull" href="./?pageid=2">Click here for the full inventory</a>
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
            <main id="wrapper">
                <h1>Our inventory</h1>
                <div id="displayInventory">
                    <h1>Loading...</h1>
                </div>
            </main>
            <dialog></dialog>
            <script src="./index.js"></script>
            <script src="./js/inventory.js"></script>';
            
            $cssFile = "./css/inventory.css";
            break;
            case "3":
                $innerHTML = '
                <div id="contactWrapper">
                    <h1>Contact us</h1>
                    <div id="mapAndInfo">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3381.853118730468!2d-81.1752897238092!3d32.04616692097576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88fb0aa8454e2fab%3A0x76b7cd80613a2034!2s4513%20Ogeechee%20Rd%2C%20Savannah%2C%20GA%2031405!5e0!3m2!1sen!2sus!4v1692816566395!5m2!1sen!2sus" style="border: 1px solid black;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <span>Adress: 4513 Ogeechee Rd, Savannah, GA 31405</span>
                        <a href="tel:+19124419680">Phone: +1 (912) 441 9680</span>
                    </div>
                </div>
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
        <a href="./">
            <img defer src="./siteMedia/logo-removebg-preview.png" alt="">
        </a>
        <menu>
            <a href="./" id="homeButton">HOME</a>

            <div page-id="2">INVENTORY</div>

            <div page-id="3">CONTACT</div>
        </menu>

        <div id="hamburgerMenu">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>
    <?php echo $innerHTML ?>
</body>

</html>