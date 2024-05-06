<?php
// Establish a database connection

$conn = mysqli_connect("localhost", "root", "", "colab_test");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Continue with your existing code
if(isset($_POST['buy_now']) && isset($_POST['product_image'])) {
    $product_image = $_POST['product_image'];

    // Sanitize the input to prevent SQL injection
    $product_image = mysqli_real_escape_string($conn, $product_image);

    // Execute an SQL query to update the amount of the product
    $sql = "UPDATE test4_discount SET m = m - 1 WHERE image = '$product_image'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if($result) {
        echo "Product purchased successfully!";
    } else {
        echo "Error purchasing product: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
