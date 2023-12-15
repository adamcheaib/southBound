"use strict";

const latestCarsContainers = document.querySelectorAll("#latestCars > a");
console.log(latestCarsContainers);

function getLatestCars() {
  fetch("./backend-data/pageSwitch.php")
    .then((r) => r.json())
    .then((allCars) => {
      document.querySelector("#latestCarsContainer > h1").textContent =
        "Our latest cars";

      const latestCar1 = document.querySelector(
        "#latestCars > a > img:nth-child(1)"
      );
      const latestCar2 = document.querySelector(
        "#latestCars > a > img:nth-child(2)"
      );
      const latestCar3 = document.querySelector(
        "#latestCars > a > img:nth-child(3)"
      );

      let decrementIndex = 1;

      if (allCars[0] !== undefined) document.getElementById("noCars").remove(); // Remove or hide the latest images so that they are hierarchical.

      for (let i = 0; i < 3; i++) {
        if (allCars[allCars.length - decrementIndex] === undefined) {
          latestCarsContainers[i].style.display = "none";
        } else {
          latestCarsContainers[i].href =
            "./displaycar/?car=" + allCars[allCars.length - decrementIndex].id;
          latestCarsContainers[i].querySelector("img").src =
            allCars[allCars.length - decrementIndex].frontpageImages[0];
        }

        decrementIndex++;
      }
    });
}

window.addEventListener("load", getLatestCars);
