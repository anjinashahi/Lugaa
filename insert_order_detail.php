<?php 
session_start(); // Start the session

// Sanitize and retrieve input data
$size = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '';
$quantity = isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '';
$description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
$product_ids = isset($_POST['product_ids']) ? htmlspecialchars($_POST['product_ids']) : '';
$color = isset($_POST['color']) ? htmlspecialchars($_POST['color']) : '';
$product_image = isset($_POST['product_image']) ? htmlspecialchars($_POST['product_image']) : '';
$product_name = isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '';
$discounted_price = isset($_POST['discounted_price']) ? htmlspecialchars($_POST['discounted_price']) : '';
$order_status = 'pending'; // Set order status to pending

// to display info 
echo "Size: " . $size . "<br>";
echo "Quantity: " . $quantity . "<br>";
echo "Description: " . $description . "<br>";
echo "Product IDs: " . $product_ids . "<br>";
echo "Color: " . $color . "<br>";
echo "Product Image: " . $product_image . "<br>";
echo "Product Name: " . $product_name . "<br>";
echo "Discounted Price: " . $discounted_price . "<br>";


// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "collab_main"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve customer details from session
if(isset($_SESSION['logged'])) {
    $loggedInName = $_SESSION['logged'];
    $sql_customer = "SELECT customer_id, address, phone_number FROM customers WHERE full_name = '$loggedInName'";
    $result_customer = $conn->query($sql_customer);
    if ($result_customer && $result_customer->num_rows > 0) {
        // Fetch customer data
        $row_customer = $result_customer->fetch_assoc();
        $customer_id = $row_customer['customer_id'];
        $address = $row_customer['address'];
        $phone = $row_customer['phone_number']; // Corrected attribute name
        
        // Display fetched data
        echo "Customer ID: " . $customer_id . "<br>";
        echo "Address: " . $address . "<br>";
        echo "Phone: " . $phone . "<br>";
    } else {
        echo "No customer found for the logged-in user.";
        // Handle this case appropriately
    }
} else {
    echo "Session 'logged' is not set.";
    // Handle this case appropriately
}

$size = strtolower($size);
// Prepare INSERT query
$sql_order = "INSERT INTO order_details (customer_id, size, color, total, quantity, product_id, order_status, address, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Calculate total
$total = strval(floatval($quantity) * floatval($discounted_price));

// Prepare and bind parameters
$stmt = $conn->prepare($sql_order);
$stmt->bind_param("sssssssss", $customer_id, $size, $color, $total, $quantity, $product_ids, $order_status, $address, $phone);

// Execute the query
if ($stmt->execute()) {
    echo "Order details inserted successfully!";
} else {
    echo "Error: " . $sql_order . "<br>" . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
