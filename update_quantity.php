<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['new']) && isset($_POST['single_price']) && isset($_POST['orderId'])) {
        $newQuantity = $_POST['new'];
        $singlePrice = $_POST['single_price'];
        $orderId = $_POST['order_id'];
        
        $newTotal = strval(floatval($newQuantity)*floatval($singlePrice));

        echo "New Quantity: " . $newQuantity . "<br>";
        echo "Single Price: " . $singlePrice . "<br>";
        echo "Order ID: " . $orderId . "<br>";
        

        // Update the quantity and single price in the order_details table
        // Use the order_id as a condition in the SQL query
        $sql_update = "UPDATE order_details SET total = '$newTotal', WHERE order_id = '$orderId'";

        if ($conn->query($sql_update) === TRUE) {
            echo "Quantity and single price updated successfully!";
        } else {
            echo "Error updating quantity and single price: " . $conn->error;
        }
    } else {
        echo "Incomplete data received.";
    }
} else {
    echo "Invalid request method.";
}
?>



<?php
// session_start();

// require 'connection.php';

// if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['total'])) {
//     $product_id = $_POST['product_id'];
//     $new_quantity = $_POST['quantity'];
//     $new_total = $_POST['total'];

//     // Update quantity and total in the order_details table
//     $sql_update = "UPDATE order_details SET quantity = '$new_quantity', total = '$new_total' WHERE product_id = '$product_id'";
//     if ($conn->query($sql_update) === TRUE) {
//         echo "Quantity and total updated successfully!";
//     } else {
//         echo "Error updating quantity and total: " . $conn->error;
//     }
// } else {
//     echo "Product ID, quantity, or total not set.";
// }
?>

