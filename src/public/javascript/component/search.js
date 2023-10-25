const form = document.getElementById("input-form");
const searchBar = document.getElementById("query");
const currentPage = document.getElementById("page-name-hidden").innerText;
const selectMenus = document.querySelectorAll('.select-menu');

const categoryMenu = document.getElementById("category-menu");
const categoryOptions = categoryMenu.querySelectorAll(".option");
const priceMenu = document.getElementById("price-menu");
const priceOptions = priceMenu.querySelectorAll(".option");
const sortMenu = document.getElementById("sort-menu");
const sortOptions = sortMenu.querySelectorAll(".option");

const adminInfo = document.getElementById("is-admin");
let isAdmin = false;

if (adminInfo) {
    isAdmin = (adminInfo.innerText == 1);
}

// Initialize variables to store selected filter values
let queryValue = searchBar.value.trim();
let selectedCategory = "All Categories";
let selectedPrice = "All Prices";
let selectedSort = "Newest First";
let page = 1; // Change this later to the current page

/* SEARCH BAR */

// Prevent the form from submitting
form.addEventListener("submit", function (event) {
    event.preventDefault();
});

// Function to update the data based on search values
searchBar &&
searchBar.addEventListener(
    "keyup",
    debounce(() => {
        queryValue = searchBar.value.trim();

        xhr = new XMLHttpRequest();
        xhr.open(
            "GET",
            `/public/${currentPage}/search/?q=${queryValue}&page=${page}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
        );

        xhr.send();

        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE) {
                if (this.status === 200) {
                    const data = JSON.parse(this.responseText);
                    updateData(data);
                } else {
                    alert("An error occured, please try again!");
                }
            }
        };
    }, DEBOUNCE_TIMEOUT)
)

/* FILTERS */

function initializeDropdown(dropdownSelector) {
    const optionMenu = document.querySelectorAll(dropdownSelector);

    optionMenu.forEach((menu) => {
        const selectBtn = menu.querySelector(".select-btn");
        const options = menu.querySelectorAll(".option");
        const sBtn_text = menu.querySelector(".select-btn-text");

        selectBtn.addEventListener("click", () => menu.classList.toggle("active"));
        options.forEach((option) => {
            option.addEventListener("click", () => {
                const selectedOption = option.querySelector(".option-text").innerText;
                sBtn_text.innerText = selectedOption;
                menu.classList.remove("active");
            });
        });
    });
}

// Remove the property "transform: rotate(-180deg);" if the dropdown icon is of the class "bx-sort-alt-2"
function removeDropdownIconTransform() {
    const dropdownIcon = document.querySelector(".bx-sort-alt-2");

    if (dropdownIcon) {
        dropdownIcon.style.transform = "rotate(0deg)";
    }
}

// Initialize all dropdowns with the class "select-menu"
initializeDropdown(".select-menu");
removeDropdownIconTransform();

// When dropdown is out of focus, close it
document.body.addEventListener('click', function (event) {
    // Check if the click target is within the select menu or its options
    selectMenus.forEach(selectMenu => {
        if (!selectMenu.contains(event.target)) {
            // If the click is outside, close the dropdown
            selectMenu.classList.remove('active');
        }
    });
});

// Function to update the selected category
function updateCategory(option) {
    selectedCategory = option.textContent.trim();

    xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        `/public/${currentPage}/search/?q=${queryValue}&page=${page}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
    );

    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                const data = JSON.parse(this.responseText);
                updateData(data);
            } else {
                alert("An error occured, please try again!");
            }
        }
    };
}

// Function to update the selected price
function updatePrice(option) {
    selectedPrice = option.textContent.trim();

    xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        `/public/${currentPage}/search/?q=${queryValue}&page=${page}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
    );

    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                const data = JSON.parse(this.responseText);
                updateData(data);
            } else {
                alert("An error occured, please try again!");
            }
        }
    };
}

// Function to update the selected sort option
function updateSort(option) {
    selectedSort = option.textContent.trim();

    xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        `/public/${currentPage}/search/?q=${queryValue}&page=${page}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
    );

    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                const data = JSON.parse(this.responseText);
                updateData(data);
            } else {
                alert("An error occured, please try again!");
            }
        }
    };
}

// Add click event listeners to the category options
categoryOptions.forEach(option => {
    option.addEventListener("click", () => {
        updateCategory(option);
    });
});

// Add click event listeners to the price options
priceOptions.forEach(option => {
    option.addEventListener("click", () => {
        updatePrice(option);
    });
});

// Add click event listeners to the sort options
sortOptions.forEach(option => {
    option.addEventListener("click", () => {
        updateSort(option);
    });
});

// Function to update the filter dropdown options
function updateCategoryOptions() {
    const searchInput = document.getElementById("category-query");
    const queryValue = searchInput.value.trim().toLowerCase();
    const options = document.querySelectorAll("#category-options li.option");

    // Hide all options initially
    options.forEach(option => {
        option.style.display = "none";
    });

    // Show options that match the query
    options.forEach(option => {
        const optionText = option.querySelector(".option-text").textContent.toLowerCase();
        if (optionText.includes(queryValue) || queryValue === "") {
            option.style.display = "flex";
        }
    });
}

// Add an event listener to the category search input with debounce
const categorySearchInput = document.getElementById("category-query");
categorySearchInput.addEventListener(
    "keyup",
    debounce(updateCategoryOptions, DEBOUNCE_TIMEOUT)
);

/* HELPER */
// Function to format price
function formatPrice(price) {
    // Convert the price to a string
    const priceString = price.toString();

    // Split the string into parts before and after the decimal point (if present)
    const parts = priceString.split('.');

    // Format the integer part with period as the thousands separator
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Combine the parts back together with a commas as the decimal separator
    return parts.join(',');
}

// To update the book page based on passed in data
const updateData = (data, resetStep=true) => {
    const bookList = document.getElementById("book-list");
    bookList.innerHTML = "";
    
    const books = data['books'];
    const pages = data['pages'];
    
    books.forEach((book) => {
        const bookCard = document.createElement("div");
        bookCard.classList.add("book-card-brief");

        const bookLink = document.createElement("a");
        if (!isAdmin) {
            bookLink.href = `/public/catalogue/preview/?book_id=${book.book_id}`;
        } else {
            bookLink.href = `/public/catalogue/edit/?book_id=${book.book_id}`;
        }

        const bookImg = document.createElement("img");
        bookImg.classList.add("book-img-brief");
        bookImg.src = book.cover_img_url;
        bookImg.alt = "Book Image";

        const bookDesc = document.createElement("div");
        bookDesc.classList.add("book-card-brief-desc");

        const bookTitle = document.createElement("h4");
        bookTitle.classList.add("book-card-title");
        bookTitle.innerText = book.title;

        const bookAuthor = document.createElement("p");
        bookAuthor.classList.add("book-card-author");
        bookAuthor.innerText = `by ${book.author}`;

        let bookPrice = null;
        if (currentPage === 'catalogue') {
            bookPrice = document.createElement("p");
            bookPrice.classList.add("book-card-price");
            bookPrice.innerText = `Rp ${formatPrice(book.price)}`;
        } else {
            bookPrice = null;
        }

        bookDesc.appendChild(bookTitle);
        bookDesc.appendChild(bookAuthor);

        if (bookPrice !== null) {
            bookDesc.appendChild(bookPrice);
        }

        bookLink.appendChild(bookImg);

        bookCard.appendChild(bookLink);
        bookCard.appendChild(bookDesc);

        bookList.appendChild(bookCard);
    });

    // Update the pagination
    const pagination = document.querySelector(".pagination-panel");
    const paginationContainer = pagination.querySelector(".pagination-container");

    paginationContainer.innerHTML = "";

    // If needed to reset the steps of pagination (i.e. searching, filtering, sorting)
    if (resetStep) {
        resetPaginationState();
    }

    // If the data fetched do not require pagination, return
    if (pages <= 1) {
        return;
    }

    // If the data fetched require pagination, recreate the pagination component
    const startBtn = document.createElement("button");
    startBtn.classList.add("pagination-button");
    startBtn.id = "startBtn";
    if (currentStep === 0) {
        startBtn.disabled = true;
    }

    const startIcon = document.createElement("i");
    startIcon.classList.add("bx", "bx-chevrons-left");

    startBtn.appendChild(startIcon);

    const prevBtn = document.createElement("button");
    prevBtn.classList.add("pagination-button", "prevNext");
    prevBtn.id = "prev";
    if (currentStep === 0) {
        prevBtn.disabled = true;
    }

    const prevIcon = document.createElement("i");
    prevIcon.classList.add("bx", "bx-chevron-left");

    prevBtn.appendChild(prevIcon);

    const paginationLinks = document.createElement("div");
    paginationLinks.classList.add("pagination-links");

    for (let i = 1; i <= pages; i++) {
        const link = document.createElement("a");
        link.classList.add("p-link");
        if (i === currentStep + 1) {
            link.classList.add("active");
        }
        link.innerText = i;

        paginationLinks.appendChild(link);
    }

    const nextBtn = document.createElement("button");
    nextBtn.classList.add("pagination-button", "prevNext");
    nextBtn.id = "next";
    if (currentStep === pages - 1) {
        nextBtn.disabled = true;
    }

    const nextIcon = document.createElement("i");
    nextIcon.classList.add("bx", "bx-chevron-right");

    nextBtn.appendChild(nextIcon);

    const endBtn = document.createElement("button");
    endBtn.classList.add("pagination-button");
    endBtn.id = "endBtn";
    if (currentStep === pages - 1) {
        endBtn.disabled = true;
    }

    const endIcon = document.createElement("i");
    endIcon.classList.add("bx", "bx-chevrons-right");

    endBtn.appendChild(endIcon);

    paginationContainer.appendChild(startBtn);
    paginationContainer.appendChild(prevBtn);
    paginationContainer.appendChild(paginationLinks);
    paginationContainer.appendChild(nextBtn);
    paginationContainer.appendChild(endBtn);

    // Add the event listeners to the pagination buttons
    addPaginationEventListeners();
};