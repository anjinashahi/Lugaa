<!-- checkout.html -->
<?php require 'connection.php'; 
session_start(); 

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Lugaa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/checkout.css">
  <link rel="stylesheet" href="css/p.css">
  <!-- <link rel="stylesheet" href="css/main.css"> -->

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
                  <a href="indexLoggedin.php">Home</a>
              </span>
              <span>
                 <a href="product_page.php">Products</a>
              </span>
              <span>
                  <a href="contactus.php">Contact Us</a>
              </span>
          </div>
          <div class="line-1"></div>
      </div>
      <div class="topright">
      <form action = "product_search.php" method = "GET">
                    <div class="input-group mb-3">
                        <input type="text" name = "query" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">
                            <button class="search">
                            <ion-icon name="search"></ion-icon>
                        </button> 
                        </span>
                        </div>
                </form>
          <div class="cart-group">
          <?php
                    
                    if(isset($_SESSION['logged'])){
                        $loggedInName = $_SESSION['logged'];
                        echo'<a href="cart_test.php">
                        <ion-icon name="cart-outline"></ion-icon>
                        </a>';
                    }
                    else{
                        echo'<a href="login.php">
                        <ion-icon name="cart-outline"></ion-icon>
                        </a>';
                    }
                    ?>
          </div>
          <div class="usericon">
          <?php
                            // session_start();
                            if(isset($_SESSION['logged'])){
                                $loggedInName = $_SESSION['logged'];
                                echo'<a href="user.php"><ion-icon name="person-circle-outline"></ion-icon></a>';
  
                                // User: ' . $loggedInName.'<ion-icon name="person-circle-outline"></ion-icon>
                                    // <div id = "name">
                                    // </div>
                                    // </a>';
                }
                else{
                    echo'<a href="login.php">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    </a>';
                }
                ?>
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
// session_start(); // Start the session if not already started
// var_dump($_SESSION);

if(!isset($_SESSION['logged'])){
    header("Location: login.php");
    die();
}

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
          <p><strong>Customer ID:</strong> <?php echo $row['customer_id']; ?></p>
            <div>
              <!-- <label for="fullname">Full Name:</label> -->
              <p><strong>Name:</strong> <?php echo $row['full_name']; ?></p>
            </div>
            <div>
              <!-- <label for="email">Email:</label> -->
              <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            </div>
            <div>
              <!-- <label for="phone">Phone Number:</label> -->
              <p><strong>Phone:</strong> <?php echo $row['phone_number']; ?></p>
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
              <label for="city">Address:</label>
              <?php echo $row['address']; ?>
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
echo $discounted_price. " " . $price;

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
      <div class = 'product-info'>
      <p>Name: $product_name</p>
      <p>Size: $size</p>
      <p>Color: $color</p>
      <p>Product Id: $product_ids</p>
      </div>";

if ($total == 0) {
    echo "<p>Total: \$$total2</p>";
} else {
    echo "<p>Total: \$$total</p>";
}
echo "</div>";


// echo "<div class='note'>
//         <form action='submit.php' method='post'>
//             <label for='message'>Enter your message:</label>
//             <textarea id='message' name='message' rows='4' cols='50'></textarea>
//             <br>
//             <input type='submit' value='Submit'>
//         </form>
//       </div>
  
//     </form>";

      
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
    $sql = "INSERT INTO order_details (customer_id, phone, address, size, color, total, quantity, product_id, note) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (empty($total)) {
        $totalToInsert = $total2;
    } else {
        $totalToInsert = $total;
    }
    $quantityAsString = strval($quantity);
    //$quantity = integer($quantity);
    $message =  $_POST['message'];
    $stmt->bind_param("sssssssss", $customer_id, $phone_number, $address, $size, $color, $totalToInsert, $quantity, $product_ids, $_POST['message']);

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
          <label for='message'>Enter your message:</label>
            <textarea id='message' name='message' rows='4' cols='50'></textarea>
            <br>
            <button class = "place-order" type="submit" name="submit" class = "btn">Submit</button>
          </form>
        </section>
      </div>
    </div>
  </div>

<!-- QR Code Section -->
<!-- <div class="qr-code">
    <h2>QR Code</h2>
    <div class="qr_code">
    <img src="images/qrcode.png" alt="QR Code">
</div>
</div> -->

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

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
<!-- Bootstrap Links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>