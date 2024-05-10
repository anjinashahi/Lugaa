<?php
session_start();
require_once("connection.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

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

// Search functionality
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $search_product_id = $_POST['search_product_id'];
        $query = "SELECT * FROM product WHERE product_id = '$search_product_id'";
        $result = mysqli_query($conn, $query);
        $product = mysqli_fetch_assoc($result);

        // Fetch available colors from database
        $query = "SELECT DISTINCT color FROM product";
        $color_result = mysqli_query($conn, $query);
        $colors = mysqli_fetch_all($color_result, MYSQLI_ASSOC);
    } elseif (isset($_POST['clear_search'])) {
        unset($product);
    } elseif (isset($_POST['purchase'])) {
        $quantity = $_POST['quantity'];
        $product_id = $_POST['product_id'];
        $query = "UPDATE product SET quantity = quantity - $quantity WHERE product_id = '$product_id'";
        mysqli_query($conn, $query);
        $success_msg = "Purchase successful!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

input[type="text"],
input[type="password"],
input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error {
    color: red;
}

.success {
    color: green;
}

.product-image {
    max-width: 200px;
    height: auto;
}
</style>
</head>
<body>

<div class="container">
    <h2>Welcome: <?php echo $user['username']; ?>!</h2>
    <h3>Your Profile</h3>
    <p>Email: <?php echo $user['email']; ?></p>

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
        <p><img src="Collab_Final/img/<?php //echo $product['image']; ?>" alt=""><?php //echo $product['image']; ?>
        <img src="" alt=""></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <p>Quantity: <input type="number" name="quantity" min="1" value="1"></p>
            <p>Color: 
                <select>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?php echo $color['color']; ?>"><?php echo $color['color']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>Size:
                <input type="radio" name="size" value="m" checked>M
                <input type="radio" name="size" value="l">L
                <input type="radio" name="size" value="xl">XL
            </p>
            <?php if (!empty($product['image'])): ?>
                <img src="C:\Users\phomb\Desktop\Collab_Final\img/<?php echo $product['image']; ?>" class="product-image" alt="Product Image">
            <?php endif; ?>
            <input type="submit" name="purchase" value="Purchase">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
