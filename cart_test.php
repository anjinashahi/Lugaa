<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="images/logo221.png" alt="Logo">
        </div>
        <div class="nav-bar">
            <div class="nav">
                <a href="indexLoggedin.php"><span>Home</span></a>
                <a href="product_page.php"><span>Products</span></a>
                <a href="contactus.html"><span>Contact Us</span></a>
            </div>
            <div class="line-1"></div>
        </div>
        <div class="topright">
            <form action="product_search.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="query" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
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

    // Query products with pending order status purchased by the customer
    $sql_products = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND order_status = 'pending'";
    $result_products = $conn->query($sql_products);

    echo '<div class="main-box">';
    if ($result_products && $result_products->num_rows > 0) {
        // echo "<h2>Products with Pending Order Status Purchased by Customer</h2>";
        
        while ($row_product = $result_products->fetch_assoc()) {
            $orderId = $row_product['order_id'];
            $singlePrice = $row_product['singlePrice'];
            $quantity = $row_product['quantity'];

            echo '<div class="cart">';
                echo '<p id="order_ids">Order IDs: '.$row_product['order_id'].'</p>';
                echo '<p id="size">Size: ' . $row_product['size'] . '</p>';
                echo '<p id="product_id">Product ID: ' . $row_product['product_id'] . '</p>';
                echo '<p id="product_color">Color: ' . $row_product['color'] . '</p>';
                echo '<p id="order_status">Order Status: ' . $row_product['order_status'] . '</p>';
                echo '<div class="quantity">';
                    echo '<button class="decrease">-</button>';
                    echo '<input type="number" value="' . $quantity . '" id="quantityInput">';
                    echo '<button class="increase">+</button>';
                echo '</div>';

                echo '<button onclick="updateOrder(' . $orderId . ')" type="button">Update</button>';

                echo '<div id="updateMessage"></div>';

                // echo '<div class="info">';
                echo '<p id="orderId" style="display: none;">' . $orderId . '</p>';
                echo '<p id="singlePrice">Single Price: ' . $singlePrice . '</p>';
                echo '<p id="total">Total: ' . intval($quantity) * intval($singlePrice) . '</p>';
                echo '<div id="selectedQuantity">Quantity: ' . $quantity . '</div>';
                // echo '</div>';

            // Remove unnecessary <br> tags and closing </div> tag
            // No code changes needed
            
        
            echo '</div>';
        };
    } else {
        echo "No products with pending order status found for this customer.";
    }
    ?>

<script>
    document.querySelector('.quantity .increase').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput');
        var selectedQuantity = document.getElementById('selectedQuantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        selectedQuantity.innerText = quantityInput.value;
        calculateTotal(); // Call calculateTotal() when quantity increases
    });

    document.querySelector('.quantity .decrease').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput');
        var selectedQuantity = document.getElementById('selectedQuantity');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            selectedQuantity.innerText = quantityInput.value;
            calculateTotal(); // Call calculateTotal() when quantity decreases
        }
    });

    function calculateTotal() {
        var singlePrice = document.getElementById('singlePrice').innerText; // Corrected ID
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
                var response = JSON.parse(this.responseText);
                if (response.success) {
                    document.getElementById('updateMessage').innerText = response.message;
                } else {
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

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
<!-- Bootstrap Links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
