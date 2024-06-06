<?php
//session_start();
require_once("connection.php");

include 'session_check.php';

$email = $_SESSION['email'];

// Fetch user profile from seller table
$query = "SELECT * FROM seller WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Change password functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify old password
    if ($old_password === $user['password']) {
        // Update password if new password matches confirm password
        if ($new_password === $confirm_password) {
            $query = "UPDATE seller SET password = '$new_password' WHERE email = '$email'";
            mysqli_query($conn, $query);
            $success_msg = "Password changed successfully.";
        } else {
            $error_msg = "New password and confirm password do not match.";
        }
    } else {
        $error_msg = "Incorrect old password.";
    }
}

// Search functionality for regular products
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $search_product_id = $_POST['search_product_id'];
        $query = "SELECT * FROM product WHERE product_id = '$search_product_id'";
        $result = mysqli_query($conn, $query);
        $product = mysqli_fetch_assoc($result);
    } 
    else{
        //echo'Not found';
    }
    if (isset($_POST['clear_search'])) {
        unset($product);
    }
    if (isset($_POST['purchase'])) {
        $quantity = $_POST['quantity'];
        $product_id = $_POST['product_id'];
        $query = "UPDATE product SET quantity = quantity - $quantity WHERE product_id = '$product_id'";
        mysqli_query($conn, $query);
        $success_msg = "Purchase successful!";
    }
}

// Search functionality for discounted products
if (isset($_POST['search_discounted'])) {
    $search_discounted_product_id = $_POST['search_discounted_product_id'];
    $query = "SELECT * FROM discounted_product WHERE product_id = '$search_discounted_product_id'";
    $result = mysqli_query($conn, $query);
    $discounted_product = mysqli_fetch_assoc($result);
} 
if (isset($_POST['clear_discounted_search'])) {
    unset($discounted_product);
}
if (isset($_POST['purchase_discounted'])) {
    $quantity = $_POST['discounted_quantity'];
    $discounted_product_id = $_POST['discounted_product_id'];
    $query = "UPDATE discounted_product SET quantity = quantity - $quantity WHERE product_id = '$discounted_product_id'";
    mysqli_query($conn, $query);
    $success_msg = "Purchase successful!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Dashboard</title>
<link rel="stylesheet" href="seller.css">
</head>
<body>

<div class="container">
    <!-- Logout button -->
    <form action="logout.php" method="post" class="logout-button">
        <button type="submit"><span class="icon">&#x1F6AA;</span>Logout</button>
    </form>

    <h2>Welcome <?php echo $user['full_name']; ?>!</h2>
    <h3>Your Profile</h3>
    <p>Email: <?php echo $user['email']; ?></p>

    <!-- Product details for regular products -->
    <div id="product_details" <?php if (!isset($product)) echo 'style="display:none;"'; ?>>
        <h3>Search Product</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="search_product_id">Product ID</label>
            <input type="text" id="search_product_id" name="search_product_id" required>
            <input type="submit" name="search" value="Search">
            <?php if (isset($product)): ?>
                <input type="submit" name="clear_search" value="Clear Search">
            <?php endif; ?>
        </form>

        <?php if (isset($product)): ?>
            <h3>Product Details</h3>
            <p>Product Name: <?php echo $product['product_name']; ?></p>
            <p>Description: <?php echo $product['description']; ?></p>
            <p>Price: $<?php echo $product['price']; ?></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <p>Quantity: <input type="number" name="quantity" min="1" value="1"></p>
                <p>Color: <?php echo $product['image'] ?></p>
                
                
                <p style="width: 300px; height: auto;"> <!-- Adjust width as needed -->
                    <img src="../img/<?php echo $product['image']; ?>" alt="" style="width: 100%; height: auto;" />
                </p>
                
                <input type="submit" name="purchase" value="Purchase">
            </form>
        <?php endif; ?>
    </div>

    <!-- Discounted product details -->
    <div id="discounted_product_details" <?php if (!isset($discounted_product)) echo 'style="display:none;"'; ?>>
        <h3>Search Discounted Product</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="search_discounted_product_id">Discounted Product ID</label>
            <input type="text" id="search_discounted_product_id" name="search_discounted_product_id" required>
            <input type="submit" name="search_discounted" value="Search">
            <?php if (isset($discounted_product)): ?>
                <input type="submit" name="clear_discounted_search" value="Clear Search">
            <?php endif; ?>
        </form>

        <?php if (isset($discounted_product)): ?>
            <h3>Discounted Product Details</h3>
            <p>Product Name: <?php echo $discounted_product['product_name']; ?></p>
            <p>Description: <?php echo $discounted_product['description']; ?></p>
            <p>Original Price: $<?php echo $discounted_product['actual_price']; ?></p>
            <p>Discounted Price: $<?php echo $discounted_product['discounted_price']; ?></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="discounted_product_id" value="<?php echo $discounted_product['product_id']; ?>">
                <p>Quantity: <input type="number" name="discounted_quantity" min="1" value="1"></p>
                <p>Color: <?php echo $discounted_product['color']; ?></p>
               
                <p style="width: 300px; height: auto;"> <!-- Adjust width as needed -->
                    <img src="../img/<?php echo $discounted_product['image']; ?>" alt="" style="width: 100%; height: auto;" />
                </p>
                <input type="submit" name="purchase_discounted" value="Purchase">
            </form>
        <?php endif; ?>
    </div>

    <!-- Change password button -->
    <button onclick="toggleProduct('product_details')">Show Regular Product</button>
    <button onclick="toggleProduct('discounted_product_details')">Show Discounted Product</button>

    <!-- Change password modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('changePasswordModal').style.display='none'">&times;</span>
            <h3>Change Password</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="old_password">Old Password</label>
                <input type="password" id="old_password" name="old_password" required>

                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <input type="submit" name="change_password" value="Change Password">
                <div class="error"><?php echo $error_msg ?? ''; ?></div>
                <div class="success"><?php echo $success_msg ?? ''; ?></div>
            </form>
        </div>
    </div>

</div>

<script>
function toggleProduct(product) {
    var productDetails = document.getElementById(product);
    var otherProduct = (product === 'product_details') ? 'discounted_product_details' : 'product_details';
    var otherProductDetails = document.getElementById(otherProduct);

    productDetails.style.display = 'block';
    otherProductDetails.style.display = 'none';
}
</script>

</body>
</html>
