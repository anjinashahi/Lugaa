document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting
    
    // Perform any necessary validation here
    
    // If validation passes, redirect to a success page
    window.location.href = 'success.html';
  });
  