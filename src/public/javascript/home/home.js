// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Dashboard";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");
topnavPageIcon.classList.add("bx-grid-alt");

document.getElementById("input-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the value of the input field
    const queryValue = document.getElementById("query").value;

    // Construct the URL with the query parameter
    const redirectUrl = `/public/catalogue/search?q=${encodeURIComponent(queryValue)}`;

    // Redirect to the constructed URL
    window.location.href = redirectUrl;
});