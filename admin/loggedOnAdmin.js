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
    const dialog = document.querySelector("dialog");

    const formData = new FormData(event.target);

    try {
        // const allInputs = document.querySelectorAll("input");
        // allInputs.forEach(input => {
        //     if (input.value === "") {
        //         dialog.innerHTML = "";
        //         dialog.innerHTML = `
        //             <div id="missingInfoNotification">
        //                 <h2>All fields must be filled!</h2>
        //                 <button>Close</button>
        //             </div>
        //         `;

        //         dialog.querySelector("button").addEventListener("click", () => dialog.close());
        //     }
        // })


        const bodyPost = new Request("./requests.php", { method: "POST", body: formData });
        const response = await fetch(bodyPost);
        const resource = await response.json();
        
        if (response.ok) {
            dialog.innerHTML = "";
            dialog.innerHTML = `
                <div id="uploadNotification">
                    <h2>Car uploaded!</h2>
                    <button>Close</button>
                </div>`;
            
            dialog.showModal();
            dialog.querySelector("button").addEventListener("click", () => { dialog.close(); fetchUploadPage() });
        } else {
             dialog.innerHTML = "";
             dialog.innerHTML = `
            <div id="missingInfoNotification">
                <h2>${resource.response}</h2>
                <button>Close</button>
            </div>
        `;

        dialog.showModal()
        dialog.querySelector("button").addEventListener("click", () => dialog.close());
        }

    } catch (err) {
        dialog.innerHTML = "";
        dialog.innerHTML = `
            <div id="missingInfoNotification">
                <h2>${err.message}</h2>
                <button>Close</button>
            </div>
        `;

        dialog.showModal()
        dialog.querySelector("button").addEventListener("click", () => dialog.close());
    }
    
}

async function fetchInventory(event) {
    try {
        const details = { username: "test", page: "inventory" };
        const bodyPost = new Request("./requests.php", { method: "POST", body: JSON.stringify(details) });

        const response = await fetch(bodyPost);

        if (response.ok) {
            mainWrapper.innerHTML = "";
            
            const resource = await response.json();

            if (resource.message.length == 0) {
                mainWrapper.innerHTML = "<h1 style='text-align: center'>No cars uploaded</h1>"
            }

            const allCars = resource.message;

            const inventoryContainer = document.createElement("div");
            inventoryContainer.id = "inventoryContainer";
            mainWrapper.appendChild(inventoryContainer);

            allCars.forEach(car => {
                const div = document.createElement("div");
                div.className = "adminInventoryPosts";
                div.setAttribute("reference", car.id);

                div.innerHTML = `
                    <img src="${car.images[0]}" class="adminCarCoverPic">
                    <div class="adminCarInformation">
                        <span style="font-weight: bold;">Year: <span style="font-weight: normal;">${car.carYear}</span></span>
                        <span style="font-weight: bold;">Make: <span style="font-weight: normal;">${car.carMake}</span></span>
                        <span style="font-weight: bold;">Model: <span style="font-weight: normal;">${car.carModel}</span></span>
                        <span style="font-weight: bold;">Miles: <span style="font-weight: normal;">${car.carMiles}</span></span>
                        <span style="font-weight: bold;">Color: <span style="font-weight: normal;">${car.carColor}</span></span>
                        <span style="font-weight: bold;">Price: <span style="font-weight: normal;">$${car.carPrice}</span></span>
                    </div>

                    <div class="adminTools">
                    <img class="deletePost" src="./media/trash.png" alt="delete">
                    </div>
                `;

                // For the above, add an img with the class "editPost" (for the styling) and add the feature to be able to edit a post.
                // The image source is: ./media/edit.png

                inventoryContainer.appendChild(div);
            })

            const deleteButtons = document.querySelectorAll(".deletePost");

            deleteButtons.forEach(deleteButton => deleteButton.addEventListener("click", (event) => {
                const carID = event.target.parentElement.parentElement.getAttribute("reference");
                confirmDelete(carID);

            }))

            async function deletePost(event) {
                const carID = event.target.parentElement.parentElement.getAttribute("reference");
                const details = { username: "test", carId: carID };
            }
        }
    } catch (err) {
        mainWrapper.innerHTML = `<h1 style="text-align: center">Something either went wrong or you have not uploaded any cars!</h1>`;
    }
}
    
alreadyUploadedButton.addEventListener("click", fetchInventory);

function confirmDelete(int) {
    const dialog = document.querySelector("dialog");
    dialog.innerHTML = "";
    dialog.showModal();
    dialog.innerHTML = `
    <h1>Delete post?</h1>
        <div class="confirmDeleteDialog">
            <div class="no">No</div>
            <div class="yes">Yes</div>
        </div>`;

    const noButton = dialog.querySelector(".no");
    noButton.addEventListener("click", () => dialog.close());

    const yesButton = dialog.querySelector(".yes");
    yesButton.addEventListener("click", () => deletePost(int));
}

async function deletePost(int) {
    try {
        const details = new Request("./requests.php", {method: "DELETE", body: JSON.stringify({ username: "test", carId: int })});
        const response = await fetch(details);

        if (response.ok) {
            const resource = await response.json();
            document.querySelector("dialog").close();
            fetchInventory();
        }
    } catch (err) {
        // Replace with a popup!
        alert("ERROOOOR")
    }
}