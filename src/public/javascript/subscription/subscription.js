// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Subscription";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");
topnavPageIcon.classList.add("bx-user-check");

document.addEventListener("DOMContentLoaded", function () {
    // Wait for the DOM content to be fully loaded

    // Get all elements with the class 'sub-button'
    var subscribeButtons = document.querySelectorAll('.sub-button');

    // Add a click event listener to each button
    subscribeButtons.forEach(function (button) {
        // Extract the author ID from the button's ID attribute
        var authorId = button.id.split('-')[1];

        // Add a click event listener
        button.addEventListener('click', function () {
            console.log('Subscribe button clicked for author ID:', authorId);
            
            // Create XHR
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost:8000/subscription'

            const SOAP_KEY = "hellofromphp"; // TODO: Replace with env

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');

            let body = `<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                            <createSubscribe xmlns="http://service.soapserver/">
                                <apiKey xmlns="">${SOAP_KEY}</apiKey>
                            </createSubscribe>
                            </Body>
                        </Envelope>`;

            xhr.send(body);

            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE) {
                    if (this.status === 200) {
                        console.log(this.responseText);
                    } else {
                        console.log('Subscription failed!');
                    }
                }
            }
        });
    });
});
