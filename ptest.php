<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quantity Input</title>
</head>
<body>

<div class="quantity">
  <button class="decrease">-</button>
  <input type="number" value="1">
  <button class="increase">+</button>
</div>

<h3 id="quantityDisplay"></h3>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const decreaseButton = document.querySelector('.decrease');
    const increaseButton = document.querySelector('.increase');
    const quantityInput = document.querySelector('.quantity input');
    const quantityDisplay = document.getElementById('quantityDisplay');
  
    decreaseButton.addEventListener('click', function() {
      let quantity = parseInt(quantityInput.value);
      if (quantity > 1) {
        quantity--;
        quantityInput.value = quantity;
        quantityDisplay.textContent = "Quantity: " + quantity;
      }
    });
  
    increaseButton.addEventListener('click', function() {
      let quantity = parseInt(quantityInput.value);
      quantity++;
      quantityInput.value = quantity;
      quantityDisplay.textContent = "Quantity: " + quantity;
    });
});
</script>

</body>
</html>
