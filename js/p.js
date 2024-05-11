// // product.js

// document.addEventListener('DOMContentLoaded', function() {
//     const decreaseButton = document.querySelector('.decrease');
//     const increaseButton = document.querySelector('.increase');
//     const quantityInput = document.querySelector('.quantity input');
//     const buyButton = document.querySelector('.buy');
//     const addToCartButton = document.querySelector('.add-to-cart');
  
//     decreaseButton.addEventListener('click', function() {
//       let quantity = parseInt(quantityInput.value);
//       if (quantity > 1) {
//         quantity--;
//         quantityInput.value = quantity;
//       }
//     });
  
//     increaseButton.addEventListener('click', function() {
//       let quantity = parseInt(quantityInput.value);
//       quantity++;
//       quantityInput.value = quantity;
//     });
  
//     // buyButton.addEventListener('click', function() {
//     //   // Redirect to checkout page or perform buy action
//     //   //window.location.href = 'checkout.html'; // Replace 'checkout.html' with your checkout page URL
//     // });
  
//     // addToCartButton.addEventListener('click', function() {
//     //   // Add product to cart
//     //   alert('Product added to cart!');
//     // });
//   });
  