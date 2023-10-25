document.addEventListener("DOMContentLoaded", function() {
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
  
    closeBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      menuBtnChange();
    });
  
    function menuBtnChange() {
      if (sidebar.classList.contains("open")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); // replacing the icons class
      } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); // replacing the icons class
      }
    }
});

const logOutButton = document.querySelector("#log-out");

logOutButton &&
    logOutButton.addEventListener("click", async (e) => {
        e.preventDefault();
        const xhr = new XMLHttpRequest();

        xhr.open("POST", "/public/user/logout");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE) {
                const data = JSON.parse(this.responseText);
                location.replace(data.redirect_url);
            }
        };
    });