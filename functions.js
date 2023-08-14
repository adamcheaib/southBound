"use strict"

async function navigationButtons(event) {
    const eventLink = event.target.getAttribute("page-id");
    const wrapper = document.getElementById("wrapper");
    window.location.href = "./?pageid=" + eventLink;
}

function popUp(innerhtml, width, height) {
    const dialog = document.querySelector("dialog");
    dialog.style.width = width + "px";
    dialog.style.height = height + "px";
    dialog.innerHTML = innerhtml;
    dialog.showModal();
}
