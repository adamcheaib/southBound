"use strict"

const uploadCarButton = document.querySelector("#adminMainMenu > div:nth-child(1)");
const alreadyUploadedButton = document.querySelector("#adminMainMenu > div:nth-child(2)");
const mainWrapper = document.getElementById("wrapper");

fetchUploadPage();
async function fetchUploadPage(event) {
    // Add so that the username that is stored from the cookies is sent along with the options-object.
    
    const details = {
        page: "uploadCars",
        username: "test"
    };
    
    const options = {
        method: "POST",
        headers: { "Content-type": "application/json; charset=UTF-8" },
        body: JSON.stringify(details)
    }

    mainWrapper.innerHTML = "<h1 style='text-align:center;'>Loading...</h1>";
    
    try {
        const response = await fetch(new Request("./requests.php"), options);
        const resource = await response.json();
        mainWrapper.innerHTML = resource.message;
    } catch (err) {
        // Make a dialog popup
        alert(err)
    }
}

uploadCarButton.addEventListener("click", fetchUploadPage);
    
alreadyUploadedButton.addEventListener("click", () => {
    // Fetch from the PHP-file and display all already existing cars.
    mainWrapper.innerHTML = ``;
})