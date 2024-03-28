// script.js

document.addEventListener('DOMContentLoaded', function () {
    const userIcon = document.getElementById('usericon');
    const overlay = document.getElementById('overlay');
    const closeButton = document.getElementById('close-btn');

    // Function to show the login popup
    function showLoginPopup() {
        overlay.style.display = 'block';
    }

    // Function to hide the login popup
    function hideLoginPopup() {
        overlay.style.display = 'none';
    }

    // Event listener for user icon click
    userIcon.addEventListener('click', showLoginPopup);

    // Event listener for close button click
    closeButton.addEventListener('click', hideLoginPopup);
});
