<?php
// Include your database connection file
require 'connection.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the POST data
    $orderId = $_POST['orderID'];
    $selectedQuantity = $_POST['quantities'];
    $newTotal = $_POST['newtotal'];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE order_details SET quantity = ?, total = ? WHERE order_id = ?");
    $stmt->bind_param("iii", $selectedQuantity, $newTotal, $orderId);

    if ($stmt->execute()) {
        // If update is successful
        $response = array(
            "success" => true,
            "message" => "Order details updated successfully"
        );
    } else {
        // If there's an error
        $response = array(
            "success" => false,
            "message" => "Error updating order details: " . $conn->error
        );
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the request method is not POST
    $response = array(
        "success" => false,
        "message" => "Invalid request method"
    );

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
