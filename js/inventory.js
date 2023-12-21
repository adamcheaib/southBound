"use strict";

function fetchAllCars() {
  fetch("./backend-data/pageSwitch.php")
    .then((r) => r.json())
    .then((allCars) => {
      document.getElementById("displayInventory").innerHTML = "";

      if (allCars.length == 0) {
        document.getElementById("displayInventory").innerHTML =
          "<h1 style='text-align: center; grid-column: 1 / 4; justify-self: center'>The inventory is currently empty. Please check again later!</h1>";
      }

      allCars.forEach((car) => {
        const anchor = document.createElement("a");
        anchor.href = "./displaycar/?car=" + car.id;
        anchor.className = "carThumbnail";

        anchor.innerHTML = `
            <img src="${car.frontpageImages[0]}">
            <div class="inventoryCarDetails">
            <div class="inventoryColorMakeModel">${car.carColor} ${car.carYear} ${car.carMake} ${car.carModel}</div>
            <div class="inventoryMiles">${car.carMiles} Miles</div>
            <div class="inventoryPrice">$${car.carPrice}</div>
            </div>
            `;

        document.getElementById("displayInventory").appendChild(anchor);
      });
    });
}

window.addEventListener("load", fetchAllCars);
