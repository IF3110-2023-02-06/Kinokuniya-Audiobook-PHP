// Setting an initial step
let currentStep = 0;

function addPaginationEventListeners() {

  // Selecting DOM elements
  const startBtn = document.querySelector("#startBtn");
  const endBtn = document.querySelector("#endBtn");
  const prevNext = document.querySelectorAll(".prevNext");
  const numbers = document.querySelectorAll(".p-link");

  // Function to update the button states
  const updateBtn = () => {

    if (numbers.length === 1) {
      startBtn.disabled = true;
      prevNext[0].disabled = true;
      endBtn.disabled = true;
      prevNext[1].disabled = true;
    }
    
    if (currentStep === numbers.length - 1) {
      endBtn.disabled = true;
      prevNext[1].disabled = true;
      startBtn.disabled = false;
      prevNext[0].disabled = false;
    } else if (currentStep === 0) {
      startBtn.disabled = true;
      prevNext[0].disabled = true;
      endBtn.disabled = false;
      prevNext[1].disabled = false;
    } else {
      endBtn.disabled = false;
      prevNext[1].disabled = false;
      startBtn.disabled = false;
      prevNext[0].disabled = false;
    }
  };

  // Add event listeners to the number links
  numbers &&
  numbers.forEach((number, numIndex) => {
    number.addEventListener("click", (e) => {
      e.preventDefault();
      // Set the current step to the clicked number link
      currentStep = numIndex;
      // Remove the "active" class from the previously active number link
      document.querySelector(".active").classList.remove("active");
      // Add the "active" class to the clicked number link
      number.classList.add("active");
      updateBtn(); // Update the button states
      
      xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        `/public/${currentPage}/search/?q=${queryValue}&page=${currentStep + 1}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
      )

      xhr.send();

      xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
          if (this.status === 200) {
            const data = JSON.parse(this.responseText);
            updateData(data, false);
          } else {
            alert("An error occured, please try again!");
          }
        }
      };
    });
  });

  // Add event listeners to the "Previous" and "Next" buttons
  prevNext &&
  prevNext.forEach((button) => {
    button.addEventListener("click", (e) => {
      // Increment or decrement the current step based on the button clicked
      currentStep += e.target.id === "next" ? 1 : -1;
      numbers.forEach((number, numIndex) => {
        // Toggle the "active" class on the number links based on the current step
        number.classList.toggle("active", numIndex === currentStep);
        updateBtn(); // Update the button states
      });

      // Open XHR to GET the page data
      xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        `/public/${currentPage}/search/?q=${queryValue}&page=${currentStep + 1}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
      )

      xhr.send();

      xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
          if (this.status === 200) {
            const data = JSON.parse(this.responseText);
            updateData(data, false);
          } else {
            alert("An error occured, please try again!");
          }
        }
      }
    });
  });

  // Add event listener to the "Start" button
  startBtn &&
  startBtn.addEventListener("click", () => {
    // Remove the "active" class from the previously active number link
    document.querySelector(".active").classList.remove("active");
    // Add the "active" class to the first number link
    numbers[0].classList.add("active");

    currentStep = 0;
    updateBtn(); // Update the button states

    // Open XHR to GET the page data
    xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      `/public/${currentPage}/search/?q=${queryValue}&page=${currentStep + 1}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
    )

    xhr.send();

    xhr.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          const data = JSON.parse(this.responseText);
          updateData(data, false);
        } else {
          alert("An error occured, please try again!");
        }
      }
    }
  });

  // Add event listener to the "End" button
  endBtn &&
  endBtn.addEventListener("click", () => {
    // Remove the "active" class from the previously active number link
    document.querySelector(".active").classList.remove("active");
    // Add the "active" class to the last number link
    numbers[numbers.length - 1].classList.add("active");

    currentStep = numbers.length - 1;
    updateBtn(); // Update the button states

    // Open XHR to GET the page data
    xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      `/public/${currentPage}/search/?q=${queryValue}&page=${currentStep + 1}&category=${selectedCategory}&price=${selectedPrice}&sort=${selectedSort}`
    )

    xhr.send();

    xhr.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          const data = JSON.parse(this.responseText);
          updateData(data, false);
        } else {
          alert("An error occured, please try again!");
        }
      }
    }
  });
}

// Function to reset the pagination state
function resetPaginationState() {
  // Set current step to zero
  currentStep = 0;
}

// Add event listeners when the DOM loads initially
addPaginationEventListeners();