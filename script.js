// Get references to the login link and overlay
const loginLink = document.getElementById('login-link');
const overlay = document.getElementById('overlay');

// Add event listener to login link
loginLink.addEventListener('click', function(event) {
    // Prevent default behavior of anchor tag
    event.preventDefault();
    // Show the login popup
    overlay.style.display = 'block';
});

// Add event listener to close button
document.getElementById('close-btn').addEventListener('click', function() {
    // Hide the login popup
    overlay.style.display = 'none';
});
