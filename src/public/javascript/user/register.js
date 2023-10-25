const usernameInput = document.querySelector("#username");
const passwordInput = document.querySelector("#password");
const passwordConfirmedInput = document.querySelector("#confirm-password");
const registrationForm = document.querySelector("#registration-form");
const usernameError = document.querySelector("#username-error");
const passwordError = document.querySelector("#password-error");
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
                    if (this.status === 400) {
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

registrationForm &&
    registrationForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const username = usernameInput.value;
        const password = passwordInput.value;

        if (!usernameValid) {
            e.preventDefault();
            usernameError.innerText = "Please fill out a valid username first!";
        } else if (!usernameValid) {
            usernameError.innerText = "Invalid username format!";
        } else {
            usernameError.innerText = "";
        }

        if (!passwordValid) {
            e.preventDefault();
            passwordError.innerText = "Please fill out a valid password first!";
        } else if (!passwordValid) {
            passwordError.innerText = "Invalid password format!";
        } else {
            passwordError.innerText = "";
        }

        if (!passwordConfirmedValid) {
            e.preventDefault();
            passwordConfirmedError.innerText = "Confirmed password doesn't match!";
        } else {
            passwordConfirmedError.innerText = "";
        }

        if (
            !usernameValid ||
            !passwordValid ||
            !passwordConfirmedValid
        ) {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/public/user/register");

        const formData = new FormData();
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