"use strict"

function fetchAllCars() {
    fetch("./backend-data/pageSwitch.php").then(r => r.json()).then(allCars => {
        document.getElementById("displayInventory").innerHTML = "";
        allCars.forEach(car => {
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
        })
    });
}

fetchAllCars();