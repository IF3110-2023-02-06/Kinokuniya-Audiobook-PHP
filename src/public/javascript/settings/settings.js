// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Settings";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");
topnavPageIcon.classList.add("bx-cog");

// Add a back button to the topnav, before the topnav-page-icon
const topnavLabel = document.querySelector(".topnav-label");
const topnavBackBtn = document.createElement("i");
topnavBackBtn.classList.add("bx", "bx-chevron-left", "topnav-page-icon");
topnavBackBtn.style.fontSize = "1.5rem";
topnavBackBtn.style.cursor = "pointer";
topnavLabel.insertBefore(topnavBackBtn, topnavLabel.childNodes[0]);

// Handle back button click
topnavBackBtn.addEventListener("click", () => {
    window.history.back();
});

const usernameInput = document.querySelector("#username");
const passwordInput = document.querySelector("#password");
const passwordConfirmedInput = document.querySelector("#confirm-password");
const settingsForm = document.querySelector("#settings-form");
const usernameError = document.querySelector("#username-error");
const passwordError = document.querySelector("#password-error");
const user_id = document.querySelector("#user-id-hidden").innerText;
const passwordConfirmedError = document.querySelector(
    "#confirm-password-error"
);

const usernameRegex = /^\w+$/;
const passwordRegex = /^\w+$/;

let usernameValid = false;
let passwordValid = false;
let passwordConfirmedValid = false;

usernameInput &&
    usernameInput.addEventListener(
        "keyup",
        debounce(() => {

            const username = usernameInput.value;

            const xhr = new XMLHttpRequest();
            xhr.open(
                "GET",
                `/public/user/username/?username=${username}`
            );

            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (this.status === 400 && username !== usernameInput.defaultValue) {
                        usernameError.innerText = "Username already taken!";
                        usernameValid = false;
                    } else if (!usernameRegex.test(username)) {
                        usernameError.innerText = "Invalid username format!";
                        usernameValid = false;
                    } else if (username.length < 5) {
                        usernameError.innerText = "Username must be at least 5 characters long.";
                        usernameValid = false;
                    } else {
                        usernameError.innerText = "";
                        usernameValid = true;
                    }
                }
            };
        }, DEBOUNCE_TIMEOUT)
    );

passwordInput &&
    passwordInput.addEventListener(
        "keyup",
        debounce(() => {

            const password = passwordInput.value;
            const passwordConfirmed = passwordConfirmedInput.value;

            if (!passwordRegex.test(password)) {
                passwordError.innerText = "Invalid password format!";
                passwordValid = false;
            } else if (password.length < 8) {
                passwordError.innerText = "Password must be at least 8 characters long.";
                passwordValid = false;
            } else {
                passwordError.innerText = "";
                passwordValid = true;
            }

            if (password !== passwordConfirmed) {
                passwordConfirmedError.innerText =
                    "Confirmed password doesn't match!";
                passwordConfirmedValid = false;
            } else {
                passwordConfirmedError.innerText = "";
                passwordConfirmedValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

passwordConfirmedInput &&
    passwordConfirmedInput.addEventListener(
        "keyup",
        debounce(() => {

            const password = passwordInput.value;
            const passwordConfirmed = passwordConfirmedInput.value;

            if (password !== passwordConfirmed) {
                passwordConfirmedError.innerText =
                    "Confirmed password doesn't match!";
                passwordConfirmedValid = false;
            } else {
                passwordConfirmedError.innerText = "";
                passwordConfirmedValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

const saveButton = document.getElementById('save-info-btn');
const confirmationPopup = document.getElementById('confirmationPopup');
const confirmButton = document.getElementById('confirmButton');
const cancelButton = document.getElementById('cancelButton');
const overlay = document.getElementById('overlay');

cancelButton.addEventListener('click', () => {
    overlay.style.display = 'none';
});

saveButton.addEventListener('click', async (e) => {
    e.preventDefault();

    if (!usernameValid && usernameInput.value !== usernameInput.defaultValue) {
        usernameError.innerText = "Please fill out a valid username first!";
    } else if (!usernameValid && usernameInput.value !== usernameInput.defaultValue) {
        usernameError.innerText = "Invalid username format!";
    } else {
        usernameError.innerText = "";
    }

    if (!passwordValid) {
        passwordError.innerText = "Please fill out a valid password first!";
    } else if (!passwordValid) {
        passwordError.innerText = "Invalid password format!";
    } else {
        passwordError.innerText = "";
    }

    if (!passwordConfirmedValid) {
        passwordConfirmedError.innerText = "Confirmed password doesn't match!";
    } else {
        passwordConfirmedError.innerText = "";
    }

    if (usernameInput.value === usernameInput.defaultValue) {
        usernameValid = true;
    }

    if (
        !usernameValid ||
        !passwordValid ||
        !passwordConfirmedValid
    ) {
        return;
    } else {
        overlay.style.display = 'block';
    }
});

confirmButton &&
    confirmButton.addEventListener("click", async () => {

        const username = usernameInput.value;
        const password = passwordInput.value;

        if (
            !usernameValid ||
            !passwordValid ||
            !passwordConfirmedValid
        ) {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST",  `/public/user/update`);

        const formData = new FormData();
        formData.append("user_id", user_id);
        formData.append("username", username);
        formData.append("password", password);

        xhr.send(formData);
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE) {
                if (this.status === 201) {
                    const data = JSON.parse(this.responseText);
                    location.replace(data.redirect_url);
                } else {
                    alert("Something went wrong! Please try again. (" + this.status + ")");
                }
            }
        };
    });