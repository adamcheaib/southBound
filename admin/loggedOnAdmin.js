"use strict"

// For security reasons, make it so that the Javascript codes are fetched once the admin has logged on!

const uploadCarButton = document.querySelector("#adminMainMenu > div:nth-child(1)");
const alreadyUploadedButton = document.querySelector("#adminMainMenu > div:nth-child(2)");
const mainWrapper = document.getElementById("wrapper");

uploadCarButton.addEventListener("click", fetchUploadPage);
fetchUploadPage();

async function fetchUploadPage(event) {
    // Add so that the username that is stored from the cookies is sent along with the options-object.
    mainWrapper.innerHTML = "";
    
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

        const moreImagesButton = document.getElementById("moreImagesButton");
        
        function addMoreImageInputs() {
            const imagesUploadContainer = document.getElementById("uploadImages");
            const imageIndex = document.querySelectorAll(".imagesToAdd").length + 1;

            const fileInputContainer = document.createElement("div");
            fileInputContainer.innerHTML =  `<input class="imagesToAdd" type="file" name="image-${imageIndex}"><span class="removeImageButton">Remove</span>`;

            fileInputContainer.querySelector(".removeImageButton").addEventListener("click", function removeMoreImageInputs(event) { event.target.parentElement.remove() });

            imagesUploadContainer.appendChild(fileInputContainer);
        }


        addMoreImageInputs();
        
        moreImagesButton.addEventListener("click", addMoreImageInputs);
        const uploadCarForm = document.querySelector("#wrapper > form");
        uploadCarForm.addEventListener("submit", uploadCar);
    } catch (err) {
        // Make a dialog popup
        alert(err)
    }
}

async function uploadCar(event) {
    event.preventDefault();

    const formData = new FormData(event.target);

    try {
        const bodyPost = new Request("./requests.php", { method: "POST", body: formData });
        const response = await fetch(bodyPost);
        
        if (response.ok) {
            const resource = await response.json();
            console.log(resource)
        } else {
            alert("ERROOOOOR");
        }

    } catch (err) {
        alert(err);
    }
    
}
    
alreadyUploadedButton.addEventListener("click", () => {
    // Fetch from the PHP-file and display all already existing cars.
    mainWrapper.innerHTML = ``;
})

