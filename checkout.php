<!-- checkout.html -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Lugaa</title>
  <!-- Include any necessary CSS files -->
  <link rel="stylesheet" href="css/checkout.css">
  <script src="js/checkout.js"></script>
</head>

<body>

  <!-- Header Section -->
  <header>
    <div class="header">
      <div class="logo">
          <a href="index.html"><img src="images/logo221.png" alt="Logo"></a>
      </div>
      <div class="nav-bar">
          <div class="nav">
              <span>
                  <a href="index.html">Home</a>
              </span>
              <span>
                 <a href="product.html">Products</a>
              </span>
              <span>
                  <a href="contactus.html">Contact Us</a>
              </span>
          </div>
          <div class="line-1"></div>
      </div>
      <div class="topright">
          <div class="search">
              <ion-icon name="search"></ion-icon>
          </div>
          <div class="cart-group">
              <ion-icon name="cart-outline"></ion-icon>
          </div>
          <div class="usericon">
              <a href="login.html">
                  <ion-icon name="person-circle-outline"></ion-icon>
              </a>
          </div>
      </div>
  </div>
  </header>

  <!-- Checkout Content -->
  <div class="checkout-container">
    <h1>Checkout</h1>
    <div class="checkout-content">
      <div class="cd">

      <!-- php code for custmer info -->
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




        <!-- Customer Information Section -->
        <section class="customer-info">
          <h2>Customer Information</h2>
          <form>
          
            <div>
              <label for="fullname">Full Name: <strong><?php echo $row['full_name']; ?></p></label> </strong>
              
            </div>
            <div>
              <label for="email">Email:<strong><p><?php echo $row['email']; ?></p></label></strong>
              
            </div>
            <div>
              <label for="phone">Phone Number:<strong><p><?php echo $row['phone_number']; ?></p></label></strong>
              
            </div>
          </form>
        </section>
        <?php
        } else {
            echo "User not found.";
        }
    } else {
        echo "User not logged in.";
    }

    // $conn->close(); // Close the database connection
?>

        <!-- Delivery Information Section -->
        <section class="delivery-info">
          <h2>Delivery Information</h2>
          <form>
            <div>
              <label for="city">Address: <strong><?php echo $row['address']; ?></label> </strong>
              
            </div>
            
          
          </form>
        </section>
      </div>

      <div class="os">
        <!-- Order Summary Section -->
        <section class="order-summary">
          <h2>Order Summary</h2>
          <?php
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
      <p id='product_info'>Name: <span style='color: #2c9713'>$product_name</span></p>
      <p id='product_info'>Size: <span style='color: #2c9713'> $size</span></p>
      <p id='product_info'>Color: <span style='color: #2c9713'>$color</span></p>";

if ($total == 0) {
    echo "<p id='product_info'>Total:<span style='color: #2c9713'> \$$total2</span></p>";
} else {
    echo "<p id='product_info'>Total: <span style='color: #2c9713'>\$$total</span></p>";
}

echo "<p id='product_info'><span style='display: none;'>$product_ids</span></p>";

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
    $size = strtolower($size);
    $sql = "INSERT INTO order_details (customer_id, phone, address, size, color, total, quantity, product_id) VALUES (?,?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (empty($total)) {
        $totalToInsert = $total2;
    } else {
        $totalToInsert = $total;
    }
    $quantityAsString = strval($quantity);
    //$quantity = integer($quantity);
    $stmt->bind_param("ssssssss", $customer_id, $phone_number, $address, $size, $color, $totalToInsert, $quantity, $product_ids);

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

          
          <!-- button to place order -->
          <form action="" method="post" >
            <button class = "place-order" type="submit" name="submit" class = "btn">Submit</button>
          </form>
        </section>
      </div>
    </div>
  </div>

<!-- QR Code Section -->
<div class="qr-code">
    <h2>QR Code</h2>
    <div class="qr_code">
    <img src="images/qrcode.png" alt="QR Code">
</div>
</div>

  <!-- Footer Section -->
  <footer>
    <div class="footer">
      <div class="line-2">
      </div>
      <div class="container-6">
          <div class="footerlogo">
              <div class="logo-1">
                  <img src="images/logo221.png" alt="flogo">
              </div>
              <span class="a-new-style-everyday-2">
                  A New Style Everyday
              </span>
          </div>
          <div class="contact">
              <div class="contact-us-3">
                  Contact Us
              </div>
              <div class="container-7">
                  <div class="pin-1">
                      <img src="images/pin1.png" alt="location">
                  </div>
                  <div class="kathmandu-nepal">
                      Kathmandu, Nepal
                  </div>
              </div>
              <div class="container">
                  <div class="phone-call-1">
                      <img src="images/phoneCall1.png" alt="phone">
                  </div>
                  <div class="phonenumber">
                      9876543210
                  </div>
              </div>
              <div class="container-11">
                  <div class="email-1">
                      <img src="images/email1.png" alt="mail">
                  </div>
                  <div class="lugaagmail-com">
                      lugaaclothing@gmail.com
                  </div>
              </div>
          </div>
          <div class="stayconnected">
              <div class="stay-connected">
                  Stay Connected
              </div>
              <div class="container-9">
                  <div class="instagram-1">
                      <img src="images/instagram1.png" alt="instagram">

                  </div>
                  <div class="facebook-1">
                      <img src="images/facebook1.png" alt="facebook">

                  </div>
              </div>
          </div>
      </div>
      <div class="container-10">
          <div class="copyright-1">
              <img src="images/copyright1.png" alt="copyright">
          </div>
          <div class="lugaa">
              2024 Lugaa
          </div>
      </div>
  </div>
  </footer>

</body>

</html>