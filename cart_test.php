<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="cart.css">
    <style>
        .cart img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        /* .cart {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        } */
        /* .quantity input {
            width: 60px;
        }
        .btn {
            margin-right: 10px;
        } */
    </style>
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
                <a href="contactus.php"><span>Contact Us</span></a>
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
    if(!isset($_SESSION['logged'])){
        header("Location: login.php");
        die();
    }
    $purchaseSuccess = false; // Flag to check if the purchase was successful
    $deleteSuccess = false; // Flag to check if the delete was successful

    if (isset($_POST['purchase'])) {
        $orderId = $_POST['order_id'];
        $sql_update = "UPDATE order_details SET order_status='purchase' WHERE order_id='$orderId'";
        if ($conn->query($sql_update) === TRUE) {
            $purchaseSuccess = true; // Set flag to true on successful update
        } else {
            echo "Error updating order status: " . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        $orderId = $_POST['order_id'];
        $sql_delete = "DELETE FROM order_details WHERE order_id='$orderId'";
        if ($conn->query($sql_delete) === TRUE) {
            $deleteSuccess = true; // Set flag to true on successful delete
        } else {
            echo "Error deleting order: " . $conn->error;
        }
    }

    if (isset($_SESSION['logged'])) {
        $loggedInName = $_SESSION['logged'];
        $sql_customer = "SELECT customer_id FROM customers WHERE full_name = '$loggedInName'";
        $result_customer = $conn->query($sql_customer);
        if ($result_customer && $result_customer->num_rows > 0) {
            $row_customer = $result_customer->fetch_assoc();
            $customer_id = $row_customer['customer_id'];
        } else {
            echo "No customer found for the logged-in user.";
        }
    } else {
        echo "Session 'logged' is not set.";
    }

    $sql_products = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND order_status = 'pending' ORDER BY order_id DESC";

    $result_products = $conn->query($sql_products);

    echo '<div class="main-box">';
    if ($result_products && $result_products->num_rows > 0) {
        while ($row_product = $result_products->fetch_assoc()) {
            $orderId = $row_product['order_id'];
            $singlePrice = $row_product['singlePrice'];
            $quantity = $row_product['quantity'];

            echo '<div class="cart">';
            echo '<form method="post" action="">';
                echo '<img src="img/' . $row_product['image'] . '" alt="Product Image">';
                echo '<div id="updateMessage"></div>';
                echo '<p id="singlePrice">Single Price: ' . $singlePrice . '</p>';
                echo '<p id="total">Total: ' . $row_product['total']. '</p>';
                echo '<div id="selectedQuantity">Quantity: ' . $quantity . '</div>';
                echo '<p id="order_status">Order Status: ' . $row_product['order_status'] . '</p>';
                

                echo '<input type="hidden" name="order_id" value="' . $orderId . '">';
                echo '<button type="submit" name="purchase" class="btn btn-primary">Purchase</button>';
                echo '<button type="submit" name="delete" class="btn btn-danger">Delete</button>';
            echo '</form>';
                echo '<div id="updateMessage"></div>';
                
            echo '</div>';
        }
    } else {
        echo "No products with pending order status found for this customer.";
    }
    ?>

    <!-- Bootstrap Toast for Thank You Message -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="thankYouToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Thank you for purchasing!
            </div>
        </div>
        <div id="deleteToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Order deleted successfully!
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- Bootstrap Links -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        <?php
        if ($purchaseSuccess) {
            echo "var toast = new bootstrap.Toast(document.getElementById('thankYouToast'));\n";
            echo "toast.show();\n";
            echo "setTimeout(function() { toast.hide(); }, 3000);\n"; // Automatically hide after 3 seconds
        }
        if ($deleteSuccess) {
            echo "var toast = new bootstrap.Toast(document.getElementById('deleteToast'));\n";
            echo "toast.show();\n";
            echo "setTimeout(function() { toast.hide(); }, 3000);\n"; // Automatically hide after 3 seconds
        }
        ?>
    </script>
</body>
</html>
