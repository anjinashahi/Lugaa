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
        // User found, display user information
        $row = $result->fetch_assoc();
?>
<div>
    <h2>user profile</h2>
    <p><strong>Customer ID:</strong> <?php echo $row['customer_id']; ?></p>
    <p><strong>Name:</strong> <?php echo $row['full_name']; ?></p>
    <p><strong>Phone:</strong> <?php echo $row['phone_number']; ?></p>
    <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
</div>

<?php
        } else {
            echo "User not found.";
        }
    } else {
        echo "User not logged in.";
    }

    // $conn->close(); // Close the database connection
?>


<?php
// Sanitize and retrieve input data
$size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : '';
$color = isset($_GET['color']) ? htmlspecialchars($_GET['color']) : '';
$quantity = isset($_GET['quantity']) ? (int)($_GET['quantity']) : 0; // Convert to integer
$description = isset($_GET['description']) ? htmlspecialchars($_GET['description']) : '';
$actual_price = isset($_GET['actual_price']) ? htmlspecialchars($_GET['actual_price']) : ''; 
$discounted_price = isset($_GET['discounted_price']) ? htmlspecialchars($_GET['discounted_price']) : ''; 
$product_image = isset($_GET['product_image']) ? htmlspecialchars($_GET['product_image'] ):'';
$product_name = isset($_GET['product_name']) ? htmlspecialchars($_GET['product_name'] ):'';
$total = strval($quantity * floatval($discounted_price));

// Retrieve customer information from the session
$customer_id = isset($row['customer_id']) ? $row['customer_id'] : '';
$phone_number = isset($row['phone_number']) ? $row['phone_number'] : '';
$address = isset($row['address']) ? $row['address'] : '';

// Basic validation - ensure required data is present
if (empty($size) || empty($color) || $quantity <= 0 || empty($actual_price) || empty($discounted_price) || !is_numeric($discounted_price)) {
    // Handle missing or invalid data
    echo "Error: Incomplete or invalid data received.";
    exit; // Exit script
}

echo "<h1>Product Info</h1>
      <p>Size: $size</p>
      <p>Color: $color</p>
      <p>Name: $product_name</p>
      <img src='img/$product_image'>
      <p>Image: $product_image</p>
      <p>Total: \$$total</p>";


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
    $sql = "INSERT INTO order_details (customer_id, phone, address, size, color, total) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $customer_id, $phone_number, $address, $size, $color, $total);

    // Execute the query
    if ($stmt->execute()) {
        echo "<h1>Order Placed Successfully!</h1>";
        echo "<h2>Order Summary</h2>";
        echo "<p>Size: $size</p>";
        echo "<p>Color: $color</p>";
        echo "<p>Total: $" . $total . "</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close statement and connection
// $stmt->close();
// $conn->close();
?>

<form action="" method="post" >
    <button type="submit" name="submit" class = "btn">Submit</button>
</form>
