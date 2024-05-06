<?php
session_start();

require 'connection.php';

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['total'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];
    $new_total = $_POST['total'];

    // Update quantity and total in the order_details table
    $sql_update = "UPDATE order_details SET quantity = '$new_quantity', total = '$new_total' WHERE product_id = '$product_id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Quantity and total updated successfully!";
    } else {
        echo "Error updating quantity and total: " . $conn->error;
    }
} else {
    echo "Product ID, quantity, or total not set.";
}
?>
