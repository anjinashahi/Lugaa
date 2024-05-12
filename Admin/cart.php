<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        /* Product Card Styles */
        .product {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden; /* Ensure contents don't overflow */
        }

        .product:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .product img {
            width: 100px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .product-info {
            padding: 20px;
        }

        .product-info h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .product-info p {
            margin: 5px 0;
        }

        .quantity {
            display: flex;
            align-items: center;
        }

        .quantity button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity button:hover {
            background-color: #0056b3;
        }

        .quantity input[type="number"] {
            width: 50px;
            text-align: center;
            margin: 0 10px;
        }

        .purchase-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .purchase-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Shopping Cart</h1>
    <!-- PHP code for product display goes here -->
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

    // Query products with pending order status purchased by the customer
    $sql_products = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND order_status = 'pending'";
    $result_products = $conn->query($sql_products);

    if ($result_products && $result_products->num_rows > 0) {
        while ($row_product = $result_products->fetch_assoc()) {
            echo '<div class="product">
                <img src="img/' . $row_product['product_image'] . '" alt="Product Image">
                <div class="product-info">
                    <h2>' . $row_product['product_name'] . '</h2>
                    <p>Size: ' . $row_product['size'] . '</p>
                    <p>Color: ' . $row_product['color'] . '</p>
                    <p>Quantity: ' . $row_product['quantity'] . '</p>
                    <p>Price: ' . $row_product['price'] . '</p>
                    <div class="quantity">
                        <button class="decrease">-</button>
                        <input type="number" value="1" min="1" max="' . $row_product['quantity'] . '" id="quantityInput">
                        <button class="increase">+</button>
                    </div>
                    <button class="purchase-button" onclick="updateQuantity()">Update Quantity</button>
                    <form method="post" action="">
                        <input type="hidden" name="order_ids" value="' . $row_product['order_id'] . '">
                        <button class="purchase-button" type="submit" name="purchase_product">Purchase</button>
                    </form>
                </div>
            </div>';
        }
    } else {
        echo "No products with pending order status found for this customer.";
    }

    if(isset($_POST['purchase_product'])) {
        $order_id = $_POST['order_ids'];
        // Update order status to "purchased" in the order_details table
        $sql_update_status = "UPDATE order_details SET order_status = 'purchased' WHERE order_id = '$order_id'";
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
</div>

<script>
function updateQuantity(){
    var orderId = document.getElementById('order_ids').innerHTML;
    var newQuantity = document.getElementById('quantityInput').value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Successfully Updated in the cart!");
        }
    };

    xhttp.open("POST", "update_quantity.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("new=" + encodeURIComponent(newQuantity) + "&orderId=" + encodeURIComponent(orderId));
}
</script>

</body>
</html>
