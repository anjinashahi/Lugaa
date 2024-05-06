<?php
session_start();

require 'connection.php';

if(isset($_SESSION['logged'])) {
    $loggedInName = $_SESSION['logged'];
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
echo 'user name :'.$loggedInName;
// Query products with pending order status purchased by the customer
$sql_products = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND order_status = 'pending'";
$result_products = $conn->query($sql_products);

if ($result_products && $result_products->num_rows > 0) {
    echo "<h2>Products with Pending Order Status Purchased by Customer</h2>";
    
    while ($row_product = $result_products->fetch_assoc()) {
        // Calculate single price
       // $single_price = $row_product['total'] / $row_product['quantity'];
        
        // for discounted price
        $product_id = $row_product['product_id'];
        $sql_discounted_price = "SELECT discounted_price FROM discounted_product WHERE product_id = '$product_id'";
        $result_discounted_price = $conn->query($sql_discounted_price);
        if ($result_discounted_price && $result_discounted_price->num_rows > 0) {
            $row_discounted_price = $result_discounted_price->fetch_assoc();
            $single_price = $row_discounted_price['discounted_price'];
        }
        echo'single price:'.$single_price;  
        // Display product details
        echo '<div>
                Order IDs:<p id="order_ids">'.$row_product['order_id'].'</p>
                <p id="size">Size: ' . $row_product['size'] . '</p>
                <p id="product_id">Product ID: ' . $row_product['product_id'] . '</p> <!-- Corrected attribute -->
                <p id="product_color">Color: ' . $row_product['color'] . '</p>
                <p id="order_status">Order Status: ' . $row_product['order_status'] . '</p> <!-- Added order status attribute -->
                <p id="total">Total: ' . $row_product['total'] . '</p> <!-- Added total attribute -->
                <p id="single_price">Single Price: ' . $single_price . '</p> <!-- Added single price -->
                <p id="fetched_quantity">Fetched Quantity: ' .$row_product['quantity']. '</p>

                New Total:<p id="new_total">' . ($single_price * $row_product['quantity']) . '</p>

                <div class="quantity">
                <button class="decrease">-</button>
                <input type="number" value="1" id="quantityInput"> <!-- Set default value to 1 -->
                <button class="increase">+</button>
                <div id="selectedQuantity" >1</div> <!-- Hide the selected quantity initially -->
                <button class="updateQuantity" onclick="updateQuantity(' . $row_product['product_id'] . ')">Update Quantity</button>
                <form method="post" action="">
                    <input type="hidden" name="order_ids" value="'.$row_product['order_id'].'">
                    <button class="purchased" type="submit" name="purchase_product">Purchase</button>
                </form>
                </div>

            </div> <br> <br>';
    }
} else {
    echo "No products with pending order status found for this customer.";
}

if(isset($_POST['purchase_product'])) {
    $order_id = $_POST['order_ids'];
    // Update order status to "purchased" in the order_details table
    $sql_update_status = "UPDATE order_details SET order_status = 'purchased' WHERE order_id = '$order_ids'";
    if ($conn->query($sql_update_status) === TRUE) {
        echo "Product purchased successfully!";
        // Optionally, you can reload the page to reflect the changes
        // header("Location: ".$_SERVER['PHP_SELF']);
        // exit();
    } else {
        echo "Error updating order status: " . $conn->error;
    }
}
?>
<script>
       // Function to update selected quantity
document.querySelectorAll('.quantity .increase').forEach(button => {
    button.addEventListener('click', function() {
        var quantityInput = this.parentElement.querySelector('input[type="number"]');
        var selectedQuantity = this.parentElement.querySelector('#selectedQuantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        selectedQuantity.innerText = quantityInput.value;
        // Show the selectedQuantity div after changing the quantity
        selectedQuantity.style.display = 'block';
        calculateNewTotal(); // Calculate new total when quantity changes
    });
});

document.querySelectorAll('.quantity .decrease').forEach(button => {
    button.addEventListener('click', function() {
        var quantityInput = this.parentElement.querySelector('input[type="number"]');
        var selectedQuantity = this.parentElement.querySelector('#selectedQuantity');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            selectedQuantity.innerText = quantityInput.value;
            // Show the selectedQuantity div after changing the quantity
            selectedQuantity.style.display = 'block';
            calculateNewTotal(); // Calculate new total when quantity changes
        }
    });
});


// Function to update quantity in database
function updateQuantity(productId) {
    var newQuantity = document.getElementById('quantityInput').value;
    var newTotal = document.getElementById('new_total').innerText;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Quantity updated successfully
            alert("Quantity updated successfully!");
        }
    };
    xhttp.open("POST", "update_quantity.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("product_id=" + productId + "&quantity=" + newQuantity + "&total=" + newTotal);
}
</script>
