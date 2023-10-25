// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "User Control";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library");
topnavPageIcon.classList.add("bx-user");

document.addEventListener('DOMContentLoaded', function() {
    const trashIcons = document.querySelectorAll('.fa-trash');

    trashIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            deleteUser(userId);
        });
    });
});

function deleteUser(userId) {
    fetch(`/public/user/deleteUser/${userId}`, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the user's row from the table
            const icon = document.querySelector(`.fa-trash[data-user-id="${userId}"]`);
            icon.closest('tr').remove();
        } else {
            // Handle the error (e.g., show an error message)
            console.error(data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
