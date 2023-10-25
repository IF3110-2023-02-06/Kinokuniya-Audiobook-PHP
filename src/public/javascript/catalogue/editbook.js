// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Edit Book";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");
topnavPageIcon.classList.add("bx-book-alt");

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

const titleInput = document.querySelector("#title");
const authorInput = document.querySelector("#author");
const categoryInput = document.querySelector("#category");
const publicationDateInput = document.querySelector("#publication-date");
const priceInput = document.querySelector("#price");
const summaryInput = document.querySelector("#summary");
const coverInput = document.querySelector("#cover");
const audioInput = document.querySelector("#audio");
const summaryHiddenInput = document.querySelector(".summary-hidden");

const titleError = document.querySelector("#title-error");
const authorError = document.querySelector("#author-error");
const categoryError = document.querySelector("#category-error");
const publicationDateError = document.querySelector("#publication-date-error");
const priceError = document.querySelector("#price-error");
const summaryError = document.querySelector("#summary-error");
const coverError = document.querySelector("#cover-error");
const audioError = document.querySelector("#audio-error");

const form = document.querySelector("#add-book-form");

// Set the default value of the summary input to the value of the hidden input
summaryInput.value = summaryHiddenInput.innerText;

// Regex to check input contains only alphanumeric characters and spaces
const titleRegex = /^[\w\s]+$/;
const authorRegex = /^[\w\s]+$/;
const categoryRegex = /^[\w\s]+$/;

let titleValid = false;
let authorValid = false;
let categoryValid = false;
let publicationDateValid = false;
let priceValid = false;
let summaryValid = false;
let coverValid = false;
let audioValid = false;

titleInput &&
    titleInput.addEventListener(
        "keyup",
        debounce(() => {
            const title = titleInput.value;

            const xhr = new XMLHttpRequest();
            xhr.open(
                "GET",
                `/public/catalogue/title/?title=${title}`
            );

            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    const res = JSON.parse(this.responseText);
                    if (this.status === 200 && res['bookexist'] == true && title !== titleInput.defaultValue) {
                        titleError.innerText = "Title already exist!";
                        titleValid = false;
                    } else if (!titleRegex.test(title)) {
                        titleError.innerText = "Invalid title format!";
                        titleValid = false;
                    } else {
                        titleError.innerText = "";
                        titleValid = true;
                    }
                }
            };
        }, DEBOUNCE_TIMEOUT)
    );

authorInput &&
    authorInput.addEventListener(
        "keyup",
        debounce(() => {
            const author = authorInput.value;

            if (!authorRegex.test(author)) {
                authorError.innerText = "Invalid author format!";
                authorValid = false;
            } else {
                authorError.innerText = "";
                authorValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

categoryInput &&
    categoryInput.addEventListener(
        "keyup",
        debounce(() => {
            const category = categoryInput.value;

            if (!categoryRegex.test(category)) {
                categoryError.innerText = "Invalid category format!";
                categoryValid = false;
            } else {
                categoryError.innerText = "";
                categoryValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

publicationDateInput &&
    publicationDateInput.addEventListener(
        "change",
        debounce(() => {
            const publicationDate = publicationDateInput.value;

            if (publicationDate === "") {
                publicationDateError.innerText = "Publication Date must be filled out";
                publicationDateValid = false;
            } else {
                publicationDateError.innerText = "";
                publicationDateValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

priceInput &&
    priceInput.addEventListener(
        "keyup",
        debounce(() => {
            const price = priceInput.value;

            // Check if price is a number
            if (isNaN(price) || price < 0) {
                priceError.innerText = "Price must be a positive number";
                priceValid = false;
            } else {
                priceError.innerText = "";
                priceValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

summaryInput &&
    summaryInput.addEventListener(
        "keyup",
        debounce(() => {
            const summary = summaryInput.value;

            if (summary === "") {
                summaryError.innerText = "Summary must be filled out";
                summaryValid = false;
            } else {
                summaryError.innerText = "";
                summaryValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

coverInput &&
    coverInput.addEventListener(
        "change",
        debounce(() => {
            const cover = coverInput.value;

            if (cover === "") {
                coverError.innerText = "Cover must be filled out";
                coverValid = false;
            } else {
                coverError.innerText = "";
                coverValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

audioInput &&
    audioInput.addEventListener(
        "change",
        debounce(() => {
            const audio = audioInput.value;

            if (audio === "") {
                audioError.innerText = "Audio must be filled out";
                audioValid = false;
            } else {
                audioError.innerText = "";
                audioValid = true;
            }
        }, DEBOUNCE_TIMEOUT)
    );

const saveButton = document.getElementById('save-info-btn');
const confirmationPopup = document.getElementById('confirmationPopup');
const confirmButton = document.getElementById('confirmButton');
const cancelButton = document.getElementById('cancelButton');
const overlay = document.getElementById('overlay');
const saveError = document.getElementById('save-error');

cancelButton.addEventListener('click', () => {
    overlay.style.display = 'none';
});

saveButton.addEventListener("click", (e) => {
    e.preventDefault();

    if (titleInput.value === titleInput.defaultValue) {
        titleValid = true;
    }

    if (authorInput.value === authorInput.defaultValue) {
        authorValid = true;
    }

    if (categoryInput.value === categoryInput.defaultValue) {
        categoryValid = true;
    }

    if (publicationDateInput.value === publicationDateInput.defaultValue) {
        publicationDateValid = true;
    }

    if (priceInput.value === priceInput.defaultValue) {
        priceValid = true;
    }

    if (summaryInput.value === summaryHiddenInput.innerText) {
        summaryValid = true;
    }

    if (!titleValid) {
        if (titleInput.value === "") {
            titleError.innerText = "Title must be filled out";
        } else {
            titleError.innerText = "Please fill out a valid title first!";
        }
    }

    if (!authorValid) {
        if (authorInput.value === "") {
            authorError.innerText = "Author must be filled out";
        } else {
            authorError.innerText = "Please fill out a valid author first!";
        }
    }

    if (!categoryValid) {
        if (categoryInput.value === "") {
            categoryError.innerText = "Category must be filled out";
        } else {
            categoryError.innerText = "Please fill out a valid category first!";
        }
    }

    if (!publicationDateValid) {
        publicationDateError.innerText = "Publication Date must be filled out";
    }

    if (!priceValid) {
        priceError.innerText = "Price must be a positive number";
    }

    if (!summaryValid) {
        if (summaryInput.value === "") {
            summaryError.innerText = "Summary must be filled out";
        } else {
            summaryError.innerText = "Please fill out a valid summary first!";
        }
    }

    if (!coverValid) {
        coverError.innerText = "Cover must be filled out";
    }

    if (!audioValid) {
        audioError.innerText = "Audio must be filled out";
    }

    if (titleValid && authorValid && categoryValid && publicationDateValid && priceValid && summaryValid && coverValid && audioValid) {
        overlay.style.display = 'block';
    } else {
        saveError.innerText = "Please fill out all the fields correctly!";
    }
});

confirmButton &&
    confirmButton.addEventListener("click", async () => {
        form.submit();
    });

form &&
form.addEventListener("submit", async (e) => {
    e.preventDefault();
});