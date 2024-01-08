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
<div id="wrapper">
<!-- Nav Menu start -->
<nav id="navigationMenu">

  <div id="hamburgerMenu">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <img
    id="siteLogo"
    src="./siteMedia/newSiteLogo.png"
    alt="Company Logo"
  />

  <div id="navigationButtonsContainer">
    <div page-id="1" class="pcNavButtons" id="homeButton">Home</div>
    <div page-id="2" class="pcNavButtons" id="inventoryButton">Inventory</div>
    <div page-id="3" class="pcNavButtons" id="contactButton">Contact</div>
  </div>
</nav>
<!-- Nav menu end -->

<!-- Banner start -->
<div id="banner">
  <div id="titleSubtitle">
    <h1>South Bound Auto Sales</h1>
    <h2>Reliable & Trustworthy</h2>
  </div>

  <div id="referAcustomer">Refer a customer and recieve $100!</div>
</div>
<!-- Banner end -->

<!-- Main Content start -->
<div id="mainContent">
  <h2 id="latestVehiclesTitle">Latest Vehicles</h2>

  <p id="noCarsText">
    Our inventory is currently empty. Please check again later.
  </p>

  <div id="latestVehiclesContainer">
    <div class="car"></div>
    <div class="car"></div>
    <div class="car"></div>
  </div>

  <a id="clickForInventory" href="./?pageid=2">
    Click here for full inventory
  </a>
</div>

<footer>
    <a href="https://maps.app.goo.gl/7NzBzqQj2gBjq9pf7" target=blank_>📌Address: 4513 Ogeechee Rd, Savannah, GA 31405</a> <br />
   <a href="tel:9124419680">☎ Phone: (912) 441 9680</a> 
</footer>
<!-- Main content end -->
</div>';

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>South Bound Auto Sales | Good Quality, Used, Refurbished Cars</title>
    <link rel="icon" type="image/png" sizes="64x64" href="./siteMedia/newSiteLogo.png">
    <link rel="stylesheet" href="./mainpage.css" />
    <link rel="stylesheet" href=<?php echo $cssFile ?>>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script defer src="./functions.js"></script>
    <script defer src="./index.js"></script>
    <script defer src="./displaycar/displaycars.js"></script>
</head>

<body>
    <?php echo $innerHTML ?>
</body>

</html>