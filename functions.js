"use strict"



function popUp(innerhtml, width, height) {
    const dialog = document.querySelector("dialog");
    dialog.style.width = width + "px";
    dialog.style.height = height + "px";
    dialog.innerHTML = innerhtml;
    dialog.showModal();
}
