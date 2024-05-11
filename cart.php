<?php
session_start();

// Include the database connection file
require 'connection.php';

// Check if the user is logged in
if (isset($_SESSION['logged'])) {
    $loggedInName = $_SESSION['logged'];
    
    // Query customer ID based on full name
    $sql_customer = "SELECT customer_id FROM customers WHERE full_name = '$loggedInName'";
    $result_customer = $conn->query($sql_customer);

    if ($result_customer && $result_customer->num_rows > 0) {
        $row_customer = $result_customer->fetch_assoc();
        $customer_id = $row_customer['customer_id'];
    } else {
        echo "No customer found for the logged-in user.";
        // Handle this case appropriately
    }
} else {
    echo "Session 'logged' is not set.";
    // Handle this case appropriately
}

// Query products with pending order status purchased by the customer
$sql_products = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND order_status = 'pending'";
$result_products = $conn->query($sql_products);

if ($result_products && $result_products->num_rows > 0) {
    // Display products with pending order status
    echo "<h2>Products with Pending Order Status Purchased by Customer</h2>";
    while ($row_product = $result_products->fetch_assoc()) {
        // Display product details
        echo '<div class="product-details">
    <p class="order-id">Order ID: ' . $row_product['order_id'] . '</p>
    <p class="size">Size: ' . $row_product['size'] . '</p>
    <p class="product-id">Product ID: ' . $row_product['product_id'] . '</p>
    <p class="color">Color: ' . $row_product['color'] . '</p>
    <p class="order-status">Order Status: ' . $row_product['order_status'] . '</p>
    <p class="total">Total: ' . $row_product['total'] . '</p>
    <p class="single-price">Single Price: ' . $row_product['singlePrice'] . '</p>
    <p class="fetched-quantity">Fetched Quantity: ' . $row_product['quantity'] . '</p>
    <p class="new-total">New Total: ' . strval(floatval($row_product['singlePrice']) * 1) . '</p>
    <form action="cart_editable.php" method="post">
        <input type="hidden" name="order_id" value="' . $row_product['order_id'] . '">
        <input type="hidden" name="single_price" value="' . $row_product['singlePrice'] . '">
        <input type="hidden" name="quantity" value="' . $row_product['quantity'] . '">
        <button class="update-quantity" type="submit">Update Quantity</button>
    </form>
    <form method="post" action="">
        <input type="hidden" name="order_id" value="' . $row_product['order_id'] . '">
        <button class="purchase" type="submit" name="purchase_product">Purchase</button>
    </form>
</div>';

    }
} else {
    echo "No products with pending order status found for this customer.";
}

if (isset($_POST['purchase_product'])) {
    $order_id = $_POST['order_id'];
    // Update order status to "purchased" in the order_details table
    $sql_update_status = "UPDATE order_details SET order_status = 'purchased' WHERE order_id = '$order_id'";
    if ($conn->query($sql_update_status) === TRUE) {
        // Display JavaScript alert for successful purchase
        echo '<script>alert("Product purchased successfully!");</script>';
        // Reload the cart.php file
        echo '<script>window.location.href = "cart.php";</script>';
    } else {
        echo "Error updating order status: " . $conn->error;
    }
}


// ?>

<script>


document.querySelectorAll('.update_quantity').forEach(function(button) {
    button.addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput').value;
        document.getElementById('selectedQuantityInput').value = quantityInput;
    });
});

document.querySelector('.quantity .increase').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput');
        var selectedQuantity = document.getElementById('selectedQuantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        selectedQuantity.innerText = quantityInput.value;
        // Show the selectedQuantity div after changing the quantity
        selectedQuantity.style.display = 'block';
    });

    document.querySelector('.quantity .decrease').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput');
        var selectedQuantity = document.getElementById('selectedQuantity');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            selectedQuantity.innerText = quantityInput.value;
            // Show the selectedQuantity div after changing the quantity
            selectedQuantity.style.display = 'block';
        }
    });


    
</script>
<!-- Include CSS styling -->
<link rel="stylesheet" href="cart.css">


