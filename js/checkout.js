// checkout.js

document.addEventListener('DOMContentLoaded', function() {
  const placeOrderButton = document.querySelector('.place-order');

  placeOrderButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Show a confirmation alert
    alert('Your order has been placed successfully!');
  });
});
