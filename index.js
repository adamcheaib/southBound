"use strict"

async function navigationButtons(event) {
    const eventLink = event.target.getAttribute("page-id");

    if (window.location.href.includes("displaycar")) {
        window.location.href = "../?pageid=" + eventLink;
    } else {
        window.location.href = "./?pageid=" + eventLink;
    }
}

const navButtons = document.querySelectorAll("#mainNav > menu > div");
navButtons.forEach(navButton => navButton.addEventListener("click", navigationButtons));

const hamburgerMenu = document.getElementById("hamburgerMenu");
const dialog = document.querySelector("dialog");
console.log(dialog);

hamburgerMenu.addEventListener("click", showPhoneMenu)

function showPhoneMenu(event) {
    dialog.innerHTML = "";
    dialog.className = "";
    dialog.id = "";
    dialog.id = "phoneMenuPopUp";

    dialog.innerHTML = `
    <div>
        <span>X</span>
        <ul>
            <li page-id="1">Home</li>
            <li page-id="2">Inventory</li>
            <li page-id="3">Contact</li>
        </ul>
    </div>
    `;

    dialog.querySelectorAll("ul > li").forEach(li => li.addEventListener("click", navigationButtons));
    dialog.querySelector("span").addEventListener("click", () => { dialog.className = ""; dialog.id = "";  dialog.close()});

    dialog.showModal();
}