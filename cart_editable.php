<?php
require 'connection.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $orderId = $_POST['order_id'];
    $singlePrice = $_POST['single_price'];
    $quantity = $_POST['quantity']; // Retrieve quantity from the form
    
    // Calculate the total
    $newTotal = intval($quantity) * intval($singlePrice);
    
    // Display the transferred data with the calculated total
    echo'<div class = container>';
    echo '<div class="quantity">
        <button class="decrease">-</button>
        <input type="number" value="' . $quantity . '" id="quantityInput"> <!-- Set default value to the submitted quantity -->
        <button class="increase">+</button>
    </div>';

    // Add an update button to update the quantity and total
    echo '<button onclick="updateOrder(' . $orderId . ')" type="button">Update</button>';
} else {
    // If the form data has not been submitted, display an error message
    echo "Error: Form data not submitted.";
}
?>

<?php 
echo '
<div id="updateMessage"></div>

<div class = "info">
    <p id="order_id"  style="display: none;">' . $orderId . '</p>
    <p>Single Price:</p><p id="single_price">' . $singlePrice . '</p>
    <p>Total:</p><p id="total">' . $newTotal . '</p> <!-- Display the calculated total -->
    <p>Quantity:</p><div id="selectedQuantity">' . $quantity . '</div> 
</div>';
echo'<button id="cart-button" onclick="location.href = \'cart.php\';" type="button">Go to cart.php</button>';
echo'</div>';
?>




<script>
document.querySelector('.quantity .increase').addEventListener('click', function() {
    var quantityInput = document.getElementById('quantityInput');
    var selectedQuantity = document.getElementById('selectedQuantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
    selectedQuantity.innerText = quantityInput.value;
    // Show the selectedQuantity div after changing the quantity
    selectedQuantity.style.display = 'block';
    // Call a function to recalculate the total when the quantity changes
    calculateTotal();
});

document.querySelector('.quantity .decrease').addEventListener('click', function() {
    var quantityInput = document.getElementById('quantityInput');
    var selectedQuantity = document.getElementById('selectedQuantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        selectedQuantity.innerText = quantityInput.value;
        // Show the selectedQuantity div after changing the quantity
        selectedQuantity.style.display = 'block';
        // Call a function to recalculate the total when the quantity changes
        calculateTotal();
    }
});

function calculateTotal() {
    var singlePrice = document.getElementById('single_price').innerText;
    var quantity = document.getElementById('quantityInput').value;
    var total = parseInt(singlePrice) * parseInt(quantity);
    document.getElementById('total').innerText = total;
}

function updateOrder(orderId) {
    var selectedQuantity = document.getElementById('selectedQuantity').innerText;
    var total = document.getElementById('total').innerText;
    
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "update_order.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Parse the JSON response
            var response = JSON.parse(this.responseText);
            // Check if the update was successful
            if (response.success) {
                // If successful, display a success message
                document.getElementById('updateMessage').innerText = response.message;
            } else {
                // If not successful, display an error message
                document.getElementById('updateMessage').innerText = response.message;
            }
        }
    };
    xhttp.send("orderID=" + encodeURIComponent(orderId) +
               "&quantities=" + encodeURIComponent(selectedQuantity) +
               "&newtotal=" + encodeURIComponent(total));
}

</script>
<link rel="stylesheet" href="cart_edit.css">