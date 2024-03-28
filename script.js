document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('overlay');
    const closeButton = document.getElementById('close-btn');
    const loginContainer = document.querySelector('.login-container');

    // Function to toggle the login popup
    function toggleLoginPopup() {
        overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
    }

    // Event listener to show/hide the login popup when the close button is clicked
    closeButton.addEventListener('click', toggleLoginPopup);

    // Event listener to hide the login popup when clicking outside the login container
    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            toggleLoginPopup();
        }
    });
});
