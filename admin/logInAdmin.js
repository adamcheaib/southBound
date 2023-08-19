"use strict"

const usernameField = document.querySelector("input[name=username]");
const passwordField = document.querySelector("input[name=password]");
const loginButton = document.querySelector("#loginForm > button");

async function attemptLogin(event) {
    try {
        const details = { username: usernameField.value, password: passwordField.value };
        const response = await fetch("./requests.php", { method: "POST", body: JSON.stringify(details) });
        const resource = await response.json();

        if (response.ok) {
            console.log(resource);
            document.querySelector("head > script").remove();
            const script = document.createElement("script");
            script.src = resource.scriptSource;
            document.body.innerHTML = resource.html;
            document.body.appendChild(script);
            document.querySelector("head > link").href = "./admin.css";
        } else {
            const dialog = document.querySelector("dialog");
            dialog.innerHTML = "";
            dialog.innerHTML = `
                <div class="wrongCredentials">
                    <h2>${resource.response}</h2>
                    <button>Close</button>
                </div>`;
            
            dialog.querySelector("button").addEventListener("click", () => dialog.close());
            dialog.showModal();
            passwordField.value = "";
        }
        
    } catch (err) {
        alert("Error!");
    }
}

loginButton.addEventListener("click", attemptLogin);