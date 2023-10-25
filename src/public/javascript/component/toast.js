const toast = document.querySelector(".toast");
const closeIcon = document.querySelector(".close");
const toastProgress = document.querySelector(".toast-progress");
let addRule = (function (style) {
  let sheet = document.head.appendChild(style).sheet;
  return function (selector, css) {
      let propText = typeof css === "string" ? css : Object.keys(css).map(function (p) {
          return p + ":" + (p === "content" ? "'" + css[p] + "'" : css[p]);
      }).join(";");
      sheet.insertRule(selector + "{" + propText + "}", sheet.cssRules.length);
  };
})(document.createElement("style"));

// Function to show success toast
function showSuccessToast(message, description) {

    // Hide error icon
    document.getElementById("error-icon").style.display = "none";
  
    addRule(".toast-progress:before", {
      content: "''",
      position: "absolute",
      bottom: 0,
      right: 0,
      height: "100%",
      width: "100%",
      "background-color": "#4070F4"
    });
  
    toast.classList.add("active");
    console.log(toast.classList);
    toastProgress.classList.add("active");
    toast.querySelector(".notif-msg").innerHTML = message;
    toast.querySelector(".notif-desc").innerHTML = description;
    toast.style.borderLeft = "6px solid #4070F4";
    document.getElementById("success-icon").style.backgroundColor = "#4070F4";
    document.getElementById("success-icon").style.display = "flex";
  
    setTimeout(() => {
      toast.classList.remove("active");
      }, 3000);
  
    setTimeout(() => {
      toastProgress.classList.remove("active");
    }, 3300);
  }

  // Function to show error toast
function showErrorToast(message, description) {
    // Hide success icon
    document.getElementById("success-icon").style.display = "none";
  
    addRule(".toast-progress:before", {
        content: "''",
        position: "absolute",
        bottom: 0,
        right: 0,
        height: "100%",
        width: "100%",
        "background-color": "#CC0000"
    });
  
    toast.classList.add("active");
    toastProgress.classList.add("active");
    toast.querySelector(".notif-msg").innerHTML = message;
    toast.querySelector(".notif-desc").innerHTML = description;
    document.getElementById("error-icon").style.backgroundColor = "#CC0000";
    document.getElementById("error-icon").style.display = "flex";
    toast.style.borderLeft = "6px solid #CC0000";
  
    setTimeout(() => {
      toast.classList.remove("active");
    }, 3000);
  
    setTimeout(() => {
      toastProgress.classList.remove("active");
    }, 3300);
  }

// Set event listener for toast close icon
closeIcon.addEventListener("click", () => {
    toast.classList.remove("active");
  
    setTimeout(() => {
      toastProgress.classList.remove("active");
    }, 300);
  });