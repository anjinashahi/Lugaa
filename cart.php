<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="cart.css">
    <!-- <link rel = "stylesheet" href = "css/main.css"> -->
    <!-- <style>
        /* Add your CSS styles here */
    </style> -->
</head>
<body>

<!-- <div class = "container"> -->
    <div class="header">
        <div class="logo">
            <img src="images/logo221.png" alt="Logo">
        </div>
        <div class="nav-bar">
            <div class="nav">
                <a href="index.php"><span>
                    Home
                </span></a>
                <a href="product_page.php"><span>
                    Products
                </span></a>
                <a href="contactus.html"><span>
                    Contact Us
                </span></a>
                
            </div>
            <div class="line-1"></div>
        </div>
        <div class="topright">
            <!-- <div class="search">
                <ion-icon name="search"></ion-icon>
            </div> -->
            <form action = "product_search.php" method = "GET">
                <div class="input-group mb-3">
                    <input type="text" name = "query" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2">
                        <button class="search">
                        <ion-icon name="search"></ion-icon>
                    </button> 
                    </span>
                    </div>
            </form>
            <div class="cart-group">
                <ion-icon name="cart-outline"></ion-icon>
            </div>
            <div class="usericon">
                <a href="login.php">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </a>
            </div>
        </div>
        </div>
    
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
// echo 'user name :'.$loggedInName;
// Query products with pending order status purchased by the customer
$sql_products = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND order_status = 'pending'";
$result_products = $conn->query($sql_products);

echo '<div class = "main-box">';

    if ($result_products && $result_products->num_rows > 0) {
        echo "<h2>Products with Pending Order Status Purchased by Customer</h2>";
        
        while ($row_product = $result_products->fetch_assoc()) {

    
            echo '<div class ="cart">
                    <p id="order_ids">Order IDs: '.$row_product['order_id'].'</p>
                    <p id="size">Size: ' . $row_product['size'] . '</p>
                    <p id="product_id">Product ID: ' . $row_product['product_id'] . '</p> <!-- Corrected attribute -->
                    <p id="product_color">Color: ' . $row_product['color'] . '</p>
                    <p id="order_status">Order Status: ' . $row_product['order_status'] . '</p> <!-- Added order status attribute -->
                    <p id="total">Total: ' . $row_product['total'] . '</p> <!-- Added total attribute -->
                    <p id="single_price">Single Price: ' . $row_product['singlePrice'] . '</p> <!-- Added single price -->
                    <p id="fetched_quantity">Quantity: ' .$row_product['quantity']. '</p>

            
                    
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

                </div> <br> <br>';
        
        };
    } else {
        echo "No products with pending order status found for this customer.";
    }
echo '</div>';
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



<script>
function updateQuantity(){
    var orderId = document.getElementById('order_ids').innerHTML;
    var newQuantity = document.getElementById('selectedQuantity').innerHTML;
    var singlePrice = document.getElementById('single_price').innerHTML;
    var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Successfully Update to cart!");
            }
        };

        xhttp.open("POST", "update_quantity.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("&new="+encodeURIComponent(newQuantity)+
        + "&single_price=" + encodeURIComponent(singlePrice)+ "&orderId=" + encodeURIComponent(orderId));
}
</script>
<!-- </div> -->
<!-- Icon Links -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
<!-- Bootstrap Links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>