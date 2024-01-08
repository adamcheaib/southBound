"use strict";

function popUp(innerhtml, width, height) {
  const dialog = document.querySelector("dialog");
  dialog.style.width = width + "px";
  dialog.style.height = height + "px";
  dialog.innerHTML = innerhtml;
  dialog.showModal();
}

function generateLoadingScreen() {
  const dialogCover = document.createElement("div");
  dialogCover.innerHTML =
    '<div id="loadingText">Loading page</div> <span class="loadingCar"> &#x1F697</span> ';
  dialogCover.id = "dialogCover";

  const carSymbol = dialogCover.querySelector(".loadingCar");
  carSymbol.style.fontSize = "100px";

  document.body.appendChild(dialogCover);
}

function removeLoadingScreen() {
  const dialogCover = document.querySelector("#dialogCover");
  dialogCover.remove();
}

function hamburgerMenuSlide() {
  // Will contain both the elements below.
  const phoneMenuContainer = document.createElement("div");

  // Will contain the different navigations menu.
  const slideContainer = document.createElement("div");

  // Will contain contain the dialog that will close the menu if clicked.
  const dialogExit = document.createElement("div");

  phoneMenuContainer.id = "phoneMenuContainer";
  slideContainer.id = "slideMenu";
  dialogExit.id = "closePhoneMenu";

  // This is to simulate the animation of the menu sliding in.
  setTimeout(() => {
    slideContainer.style.left = 0 + "px";
  }, 50);

  slideContainer.innerHTML = `
    <div>
      <h3>Menu</h3>
      <a href="./?pageid=1" class="phoneNavButtons" id="phoneToHome">Home</a>
      <a href="./?pageid=2" class="phoneNavButtons" id="phoneToInventory">Inventory</a>
      <a href="./?pageid=3" class="phoneNavButtons" id="phoneToContact">Contact</a>
    </div>
  `;

  dialogExit.addEventListener("click", () => phoneMenuContainer.remove());

  phoneMenuContainer.appendChild(slideContainer);
  phoneMenuContainer.appendChild(dialogExit);

  document.body.appendChild(phoneMenuContainer);
}
