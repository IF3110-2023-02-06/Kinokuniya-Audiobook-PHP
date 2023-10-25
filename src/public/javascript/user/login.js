const usernameInput = document.querySelector("#username");
const passwordInput = document.querySelector("#password");
const loginForm = document.querySelector("#login-form");
const usernameError = document.querySelector("#username-error");
const passwordError = document.querySelector("#password-error");
const loginError = document.querySelector("#login-error");

const usernameRegex = /^\w+$/;
const passwordRegex = /^\w+$/;

let usernameValid = false;
let passwordValid = false;

usernameInput &&
    usernameInput.addEventListener(
        "keyup",
        debounce(() => {
            const username = usernameInput.value;

            if (!usernameRegex.test(username)) {
                usernameError.innerText = "Invalid username format!";
                usernameValid = false;
            } else {
                usernameError.innerText = "";
                usernameValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

passwordInput &&
    passwordInput.addEventListener(
        "keyup",
        debounce(() => {
            const password = passwordInput.value;

            if (!passwordRegex.test(password)) {
                passwordError.innerText = "Invalid password format!";
                passwordValid = false;
            } else {
                passwordError.innerText = "";
                passwordValid = true;
            }
        })
    );

loginForm &&
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const username = usernameInput.value;
        const password = passwordInput.value;

        if (!username || username==="") {
            usernameError.innerText = "Please fill out your username first!";
            usernameValid = false;
        } else if (!usernameRegex.test(username)) {
            usernameError.innerText = "Invalid username format!";
            usernameValid = false;
        } else {
            usernameError.innerText = "";
            usernameValid = true;
        }

        if (!password || password==="") {
            passwordError.innerText = "Please fill out your password first!";
            passwordValid = false;
        } else if (!passwordRegex.test(password)) {
            passwordError.innerText = "Invalid password format!";
            passwordValid = false;
        } else {
            passwordError.innerText = "";
            passwordValid = true;
        }

        if (!usernameValid || !passwordValid) {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/public/user/login");

        const formData = new FormData();
        formData.append("username", username);
        formData.append("password", password);

        xhr.send(formData);
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE) {
                if (this.status === 201) {
                    document.querySelector("#login-error").innerText = "";
                    const data = JSON.parse(this.responseText);
                    location.replace(data.redirect_url);
                } else {
                    document.querySelector("#login-error").innerText = "Invalid username or password!";
                }
            }
        };
    });