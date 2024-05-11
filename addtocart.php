// Sanitize and retrieve input data
$size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : '';
$color = isset($_GET['color']) ? htmlspecialchars($_GET['color']) : '';
$quantity = isset($_GET['quantity']) ? (int)($_GET['quantity']) : 0; // Convert to integer
$description = isset($_GET['description']) ? htmlspecialchars($_GET['description']) : '';
$product_ids = isset($_GET['product_ids']) ? htmlspecialchars($_GET['product_ids']) : '';
$price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : ''; 
$discounted_price = isset($_GET['discounted_price']) ? htmlspecialchars($_GET['discounted_price']) : ''; 
$product_image = isset($_GET['product_image']) ? htmlspecialchars($_GET['product_image'] ):'';
$product_name = isset($_GET['product_name']) ? htmlspecialchars($_GET['product_name'] ):'';
$total = strval($quantity * floatval($discounted_price));
$total2 = strval($quantity * floatval($price));

echo"<script>console.log('Product ID:', product_id); </script>";

// Retrieve customer information from the session
$customer_id = isset($row['customer_id']) ? $row['customer_id'] : '';
$phone_number = isset($row['phone_number']) ? $row['phone_number'] : '';
$address = isset($row['address']) ? $row['address'] : '';

// Basic validation - ensure required data is present
// if (empty($size) || empty($color) || $quantity <= 0  || !is_numeric($discounted_price)) {
//     // Handle missing or invalid data
//     echo "Error: Incomplete or invalid data received.";
//     exit; // Exit script
// }

echo "<div class='product'>
      <img src='img/$product_image'>
      <p>Name: $product_name</p>
      <p>Size: $size</p>
      <p>Color: $color</p>
      <p>Product Id: $product_ids</p>";

if ($total == 0) {
    echo "<p>Total: \$$total2</p>";
} else {
    echo "<p>Total: \$$total</p>";
}
echo "</div>";

//session_start(); // Start the session





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

// Prepare INSERT query
if(isset($_POST['submit'])){

    $sql = "INSERT INTO order_details (customer_id, phone, address, size, color, total, quantity, product_id, order_status) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (empty($total)) {
        $totalToInsert = $total2;
    } else {
        $totalToInsert = $total;
    }
    $quantityAsString = strval($quantity);
    //$quantity = integer($quantity);
    $order_status = 'pending';
    $stmt->bind_param("ssssssss", $customer_id, $phone_number, $address, $size, $color, $totalToInsert, $quantity, $product_ids, $order_status);

    // Execute the query
    if ($stmt->execute()) {
        echo'done';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close statement and connection
// $stmt->close();
// $conn->close();
?>
