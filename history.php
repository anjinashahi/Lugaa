<?php 
session_start(); // Start the session if not already started

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collab_main";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

if(isset($_SESSION['logged'])) {
    $loggedInEmail = $_SESSION['logged'];
    //$loggedInEmail is full name

    // Fetch user information from the database based on the logged-in email
    $sql = "SELECT * FROM customers WHERE full_name = '$loggedInEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, get the customer_id
        $row = $result->fetch_assoc();
        $customer_id = $row['customer_id'];

        // Now, retrieve all orders placed by this customer from the order_details table
        $orderSql = "SELECT * FROM order_details WHERE customer_id = '$customer_id'";
        $orderResult = $conn->query($orderSql);

        if ($orderResult->num_rows > 0) {
            // Display each order
            while ($orderRow = $orderResult->fetch_assoc()) {
                // Output order details here
                // For example:
                echo "<div>Customer ID: " . $orderRow['customer_id'] . ". <br>" .
                "Order ID: " . $orderRow['order_id'] . ". <br>" .
                "Product ID: " . $orderRow['product_id'] . ". <br>" .
                "Phone: " . $orderRow['phone'] . ". <br>" .
                "Address: " . $orderRow['address'] . ". <br>" .
                "Quantity: " . $orderRow['quantity'] . ". <br>" .
                
                "Total: " . $orderRow['total'] . "</div><br><br>"
                ;
                
            }
        } else {
            echo "No orders found for this customer.";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
}
?>
