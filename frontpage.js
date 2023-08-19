"use strict"

const latestCarsContainers = document.querySelectorAll("#latestCars > a");
console.log(latestCarsContainers);

function getLatestCars() {
    fetch("./backend-data/pageSwitch.php").then(r => r.json()).then(allCars => {

        const latest1 = allCars[allCars.length - 1];
        const latest2 = allCars[allCars.length - 2];
        const latest3 = allCars[allCars.length - 3];

        latestCarsContainers[0].href = `./displaycar/?car=${latest1["id"]}`;
        latestCarsContainers[1].href = `./displaycar/?car=${latest2["id"]}`;
        latestCarsContainers[2].href = `./displaycar/?car=${latest3["id"]}`;

        latestCarsContainers[0].querySelector("img").src = latest1.frontpageImages[0];
        latestCarsContainers[1].querySelector("img").src = latest2.frontpageImages[0];
        latestCarsContainers[2].querySelector("img").src = latest3.frontpageImages[0];
    });    
}

getLatestCars()