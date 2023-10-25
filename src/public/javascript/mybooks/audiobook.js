// Top nav label
const topnavLabel = document.querySelector(".topnav-label");

// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Audiobook";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");

// Add back icon
let backIcon = document.createElement("i");
backIcon.classList.add("bx", "bx-chevron-left", "topnav-page-icon");

// Style the back icon
backIcon.style.fontSize = "1.5rem";
backIcon.style.cursor = "pointer";

// Append as first child of topnav label
topnavLabel.insertBefore(backIcon, topnavLabel.childNodes[0]);

// Handle back button click
backIcon.addEventListener("click", () => {
    window.history.back();
});

// Get a reference to the button and the icon
const playButton = document.getElementById('play');
const playIcon = playButton.querySelector('i');

// Add a click event listener to the button
playButton.addEventListener('click', function () {
    // Toggle the class between 'icon-btn' and 'icon-btn-alt'
    playButton.classList.toggle('icon-btn');
    playButton.classList.toggle('icon-btn-alt');

    // Toggle the icon between 'bx-play' and 'bx-pause'
    if (playIcon.classList.contains('bx-play')) {
        playIcon.classList.remove('bx-play');
        playIcon.classList.add('bx-pause');
        // Change the button text if needed
        playButton.querySelector('span').textContent = 'Pause Audiobook';
    } else {
        playIcon.classList.remove('bx-pause');
        playIcon.classList.add('bx-play');
        // Change the button text if needed
        playButton.querySelector('span').textContent = 'Play Audiobook';
    }
});
