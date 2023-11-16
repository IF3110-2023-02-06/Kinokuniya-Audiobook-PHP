// Change the topnav-page-text to the current page
document.getElementById("topnav-page-text").innerHTML = "Subscription";

// Change the topnav-page-icon to the current page, delete the old icon classes and add the new icon classes
let topnavPageIcon = document.getElementById("topnav-page-icon");
topnavPageIcon.classList.remove("bx-grid-alt", "bx-book", "bx-cog", "bx-library", "bx-cart");
topnavPageIcon.classList.add("bx-user-check");

const SOAP_KEY = "90d9b00a-5efc-4c4e-a53f-2be134a96df2"; // TODO: Replace with env
const userID = document.querySelector("#user-id-hidden").innerText;
const subscriberName = document.querySelector("#username-hidden").innerText;

document.addEventListener("DOMContentLoaded", function () {
    // Wait for the DOM content to be fully loaded

    // Get all elements with the class 'sub-button'
    var subscribeButtons = document.querySelectorAll('.sub-button');

    // Add a click event listener to each button
    subscribeButtons.forEach(function (button) {
        // Extract the author ID from the button's ID attribute
        // ID format: unsub-{authorId}-{creatorName}
        var authorId = button.id.split('-')[1];
        var creatorName = button.id.split('-')[2];

        // Add a click event listener
        button.addEventListener('click', function () {
            console.log('Subscribe button clicked for author ID:', authorId);
            console.log('User ID:', userID);
            
            // Create XHR
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost:8001/api/subscribe'

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');

            let body = `<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                            <createSubscribe xmlns="http://service.kinokuniya/">
                                <arg0 xmlns="">${authorId}</arg0>
                                <arg1 xmlns="">${userID}</arg1>
                                <arg2 xmlns="">${creatorName}</arg2>
                                <arg3 xmlns="">${subscriberName}</arg3>
                                <arg4 xmlns="">${SOAP_KEY}</arg4>
                            </createSubscribe>
                            </Body>
                        </Envelope>`;

            xhr.send(body);

            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE) {
                    if (this.status === 200) {
                        console.log(this.responseText);
                        // Change the button's text to 'Subscribed'
                        button.innerText = 'Subscribed';
            
                        // Disable the button
                        button.disabled = true;
            
                        // Change the button's class to 'sub-button-disabled'
                        button.classList.add('sub-button-disabled');
                    } else {
                        console.log('Subscription failed!');
                    }
                }
            }

        });
    });
});
