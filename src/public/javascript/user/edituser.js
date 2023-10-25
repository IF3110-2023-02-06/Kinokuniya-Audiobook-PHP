// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Editing user";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library");
topnavPageIcon.classList.add("bx-cog");