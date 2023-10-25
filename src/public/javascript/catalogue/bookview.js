// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "View Book";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");
topnavPageIcon.classList.add("bx-book-reader");

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

// Add event listener to the add to cart button
const addToCartButton = document.getElementById("add-to-cart");
const book_id = document.getElementById("book-id-hidden").textContent;

addToCartButton &&
    addToCartButton.addEventListener("click", () => {

        // Add the book to the cart
        xhrPost = new XMLHttpRequest();
        xhrPost.open("POST", "/public/catalogue/preview");
        
        const formData = new FormData();
        formData.append("book_id", book_id);

        xhrPost.send(formData);
        xhrPost.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE) {
                if (xhrPost.status == 200) {

                    // If the book was added to the cart successfully, alert the user
                    showSuccessToast("Success", "You have successfully added the book to your cart.");

                } else if (xhrPost.status == 302) {
                    // Already in cart, alert the user
                    showErrorToast("Error", "This book is already in your cart.");
                } else {
                    // If the book was not added to the cart successfully, alert the user
                    showErrorToast("Error", `There was an error adding the book to your cart. (${xhrPost.status})`);
                }
            }
        }
});

const audio = document.getElementById("audio");
const playPauseButton = document.getElementById("play-pause-button");
const playIcon = document.getElementById("play-icon");
const pauseIcon = document.getElementById("pause-icon");
const progressContainer = document.getElementById("progress-container");
const progressBar = document.getElementById("progress-bar");
const thumb = document.getElementById("thumb");
const timeLeft = document.getElementById("time-left");

// Toggle play/pause
playPauseButton &&
playPauseButton.addEventListener("click", () => {
    if (audio.paused || audio.ended) {
        audio.play();
    } else {
        audio.pause();
    }
});

// Update play/pause button and progress bar
audio &&
audio.addEventListener("play", () => {
    playIcon.style.display = "none";
    pauseIcon.style.display = "inline";
});

audio &&
audio.addEventListener("pause", () => {
    playIcon.style.display = "inline";
    pauseIcon.style.display = "none";
});

audio &&
audio.addEventListener("timeupdate", () => {
    const currentTime = audio.currentTime;
    const duration = audio.duration;

    // Update progress bar
    const progress = (currentTime / duration) * 100;
    progressBar.style.width = progress + "%";

    // Update thumb position
    const thumbPosition = (progressContainer.offsetWidth / 100) * progress;
    thumb.style.left = `${thumbPosition}px`;

    // Update time left
    const remainingTime = duration - currentTime;
    const minutes = Math.floor(remainingTime / 60);
    const seconds = Math.floor(remainingTime % 60);
    timeLeft.textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
});

// Allow seeking to a specific position on click
progressContainer &&
progressContainer.addEventListener("click", (e) => {
    const clickX = e.clientX || e.touches[0].clientX;
    const containerLeftX = progressContainer.getBoundingClientRect().left;
    const containerWidth = progressContainer.offsetWidth;
    const clickPosition = (clickX - containerLeftX) / containerWidth;

    const duration = audio.duration;
    const newPosition = duration * clickPosition;

    // Set the audio's current time to the new position
    audio.currentTime = newPosition;
});

// Add thumb dragging functionality
let isDragging = false;

thumb &&
thumb.addEventListener("mousedown", () => {
    isDragging = true;
});

document.addEventListener("mousemove", (e) => {
    if (!isDragging) return;

    const containerLeftX = progressContainer.getBoundingClientRect().left;
    const containerWidth = progressContainer.offsetWidth;
    const clickX = e.clientX;

    let clickPosition = (clickX - containerLeftX) / containerWidth;

    if (clickPosition < 0) {
        clickPosition = 0;
    } else if (clickPosition > 1) {
        clickPosition = 1;
    }

    const duration = audio.duration;
    const newPosition = duration * clickPosition;

    // Set the audio's current time to the new position
    audio.currentTime = newPosition;
});

document.addEventListener("mouseup", () => {
    isDragging = false;
});