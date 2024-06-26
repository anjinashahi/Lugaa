<?php
require 'connection.php';
session_start(); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lugaa | Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href = "css/main.css">

  <style>
    /* Insert the provided CSS from product.css file here */
    <?php include 'css/product.css'; ?>
    
  </style>
</head>
<body>
  <!-- Header Section -->
  <div class="header">
    <div class="logo">
      <a href="indexLoggedin.php"><img src="images/logo221.png" alt="Logo"></a>
    </div>
    <div class="nav-bar">
      <div class="nav">
        <span><a href="indexLoggedin.php">Home</a></span>
        <span><a href="product_page.php">Products</a></span>
        <span><a href="contactus.php">Contact Us</a></span>
      </div>
      <div class="line-1"></div>
    </div>
    <div class="topright">
      <!-- <div class="search"><ion-icon name="search"></ion-icon></div>
      <div class="cart-group"><ion-icon name="cart-outline"></ion-icon></div>
      <div class="usericon"><a href="indexLoggedin.php"><ion-icon name="person-circle-outline"></ion-icon></a></div> -->
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
  </div>

  <!-- Product Section -->
  <div class="container">
    <section class="product">
      <div class="product-section">
        <h2 class="title">Products</h2>
        <div class="product-row">
        
    <?php 
    error_reporting(E_ALL & ~E_NOTICE);

            if(isset($_GET['query'])) {
                $query = $_GET['query'];
            
                // Sanitize user input to prevent SQL injection
                $safe_query = mysqli_real_escape_string($conn, $query);
            
                // Execute the search query
                $raw_results = mysqli_query($conn, "SELECT * FROM product WHERE `product_name` LIKE '%$safe_query%' OR `description` LIKE '%$safe_query%'") or die(mysqli_error($conn));
            
                // Check if any results are found
                if(mysqli_num_rows($raw_results) > 0) {
                    // Loop through the results and display them
                    while($row = mysqli_fetch_array($raw_results)) :
                        // Display search results here
                        ?>
                        <div class="product">
        <img src="img/<?php echo $row['image']; ?>" alt="">
        <div class="details">
            <h3><?php echo $row["product_name"]; ?></h3>
            <p><?php echo $row["price"]; ?></p>
            <!-- <p id = "product_idss"> <?php //echo $row['product_id']?> </p> -->
            <!-- Form to send product ID to test2.php -->
            <form action="product_details_product.php" method="post">
                <input type="hidden" name="product_id2" value="<?php echo $_SESSION['product_id2']; ?>">
                
                <button type="submit" class="buy-button">Buy Now</button>
            </form>
        </div>
    </div>
                        <?php
                    endwhile;
                } else {
                    echo "No results found.";
                }
            }
?>
    
<?php error_reporting(E_ALL); ?>
        </div>
      </div>
    </section>
  </div>
  <!-- Footer Section -->
  <div class="footer">
    <div class="line-2"></div>
    <div class="container-6">
      <div class="footerlogo">
        <div class="logo-1">
          <img src="images/logo221.png" alt="flogo">
        </div>
        <span class="a-new-style-everyday-2">A New Style Everyday</span>
      </div>
      <div class="contact">
        <div class="contact-us-3">Contact Us</div>
        <div class="container-7">
          <div class="pin-1">
            <img src="images/pin1.png" alt="location">
          </div>
          <div class="kathmandu-nepal">Kathmandu, Nepal</div>
        </div>
        <div class="container">
          <div class="phone-call-1">
            <img src="images/phoneCall1.png" alt="phone">
          </div>
          <div class="phonenumber">9876543210</div>
        </div>
        <div class="container-11">
          <div class="email-1">
            <img src="images/email1.png" alt="mail">
          </div>
          <div class="lugaagmail-com">lugaaclothing@gmail.com</div>
        </div>
      </div>
      <div class="stayconnected">
        <div class="stay-connected">Stay Connected</div>
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
      <div class="lugaa">2024 Lugaa</div>
    </div>
  </div>

  <!-- JavaScript for product click -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
<!-- Bootstrap Links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</body>
</html>

