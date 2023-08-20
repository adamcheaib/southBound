"use strict"

async function navigationButtons(event) {
    const eventLink = event.target.getAttribute("page-id");
    const wrapper = document.getElementById("wrapper");

    if (window.location.href.includes("displaycar")) {
        window.location.href = "../?pageid=" + eventLink;
    } else {
        window.location.href = "./?pageid=" + eventLink;
    }
}

const navButtons = document.querySelectorAll("#mainNav > menu > div");
navButtons.forEach(navButton => navButton.addEventListener("click", navigationButtons));