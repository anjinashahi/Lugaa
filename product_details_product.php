<?php require 

'connection.php'; 

session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Name - Lugaa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/p.css">
  <script src="js/p.js" defer></script>
</head>
<body>

  <!-- Header Section -->
  <div class="header">
    <div class="header">
        <div class="logo">
          <a href="index.h"><img src="images/logo221.png" alt="Logo"></a>
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
              <a href="contactus.html">Contact Us</a>
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
                echo'<a href="user.php">
                User: ' . $loggedInName.'<ion-icon name="person-circle-outline"></ion-icon>
                    <div id = "name">
                    </div>
                    </a>';
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
  <!-- Product Details Section -->
  <div class="container">
    <div class="product-details">
    <!-- <div class="product-info"> -->

    <!-- fetched data from table -->
    <div class = "fetched">
<?php
// Start the session

// Check if product_id session variable is set
if(isset($_POST['product_id2'])) {
    $product_id2 = $_POST['product_id2'];
    //echo "Product ID 2: " . $product_id2;
    echo  $product_id2;
    $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id2");
    $products_ids = $product_id2;
    if(mysqli_num_rows($result) > 0) {
      // Output fetched data
      while ($row = mysqli_fetch_assoc($result)) {
        echo '

        <div class="product-image">
            <img src="img/' . $row['image'] . '" alt="Product Image">
        </div>
        <div class = "right">
        <div class="product-info">
            
            <p><h2>' . $row["product_name"] . '</h2></p>
            <p id="product_ids" style="display: none;">' . $products_ids. '</p>

            <p id = "color">'.$row["color"].'</p>
            <p class="description" id = "description">' . $row["description"] . '</p>
            <div class="price" id = "price"> <h3>RS ' . $row["price"] . '</h3></div>
  
        </div>';
      }
      if(isset($_SESSION['logged'])) {
        $loggedInName = $_SESSION['logged'];
        $sql = "SELECT customer_id FROM customers WHERE full_name = '$loggedInName'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customer_id = $row['customer_id'];
            //echo "User: " . $loggedInName . ", Customer ID: " . $customer_id;
            //echo'Customer ID:<p id = "customer_id">'.$customer_id.'</p>';
        } else {
            echo "No customer found for the logged-in user.";
        }
    } else {
        echo "Session 'logged' is not set.";
      }
     
    } else {
      echo "<div class='product-info'>No results found for product ID: $product_id</div>";
  }
} 
else {
  echo "<div class='product-info'>Product ID is not set in the session.</div>";
}

echo '
<div class="quantity">
  <button onclick="toggleSize(\'M\')">M</button>
  <button onclick="toggleSize(\'L\')">L</button>
  <button onclick="toggleSize(\'XL\')">XL</button>
</div>
Please Select Size
<div id="selectedSize" style="display: none;"></div>
<div class="sizes" style="display: none;"> <!-- Hide the sizes class initially -->
  <span class="size M">M</span>
  <span class="size L">L</span>
  <span class="size XL">XL</span>
</div>
<div class="quantity">
  <button class="decrease">-</button>
  <input type="number" value="1" id="quantityInput"> <!-- Set default value to 1 -->
  <button class="increase">+</button>
  <div id="selectedQuantity" style="display: none;">1</div> <!-- Hide the selected quantity initially -->
</div>
<button class="buy" onclick="redirectToCheckout()">Buy Now</button>
<button class="add-to-cart" onclick="addToCart()">Add to Cart</button>
</div>
</div>
';
?>

<script>
  function toggleSize(size) {
      var sizeElements = document.getElementsByClassName('size');
      for (var i = 0; i < sizeElements.length; i++) {
          if (sizeElements[i].classList.contains(size)) {
              sizeElements[i].style.display = 'inline-block';
              // Update the content of the selectedSize div
              document.getElementById('selectedSize').innerText = size;
          } else {
              sizeElements[i].style.display = 'none';
          }
      }
      // Show the sizes div after selecting a size
      document.querySelector('.sizes').style.display = 'block';
  }

  // Function to update selected quantity
  document.querySelector('.quantity .increase').addEventListener('click', function() {
      var quantityInput = document.getElementById('quantityInput');
      var selectedQuantity = document.getElementById('selectedQuantity');
      quantityInput.value = parseInt(quantityInput.value) + 1;
      selectedQuantity.innerText = quantityInput.value;
      // Show the selectedQuantity div after changing the quantity
      selectedQuantity.style.display = 'block';
  });

  document.querySelector('.quantity .decrease').addEventListener('click', function() {
      var quantityInput = document.getElementById('quantityInput');
      var selectedQuantity = document.getElementById('selectedQuantity');
      if (parseInt(quantityInput.value) > 1) {
          quantityInput.value = parseInt(quantityInput.value) - 1;
          selectedQuantity.innerText = quantityInput.value;
          // Show the selectedQuantity div after changing the quantity
          selectedQuantity.style.display = 'block';
      }
  });

  function redirectToCheckout() {
  var description = document.getElementById('description').innerText;
  var price = document.getElementById('price').innerText;
  var product_ids = document.getElementById('product_ids').innerText;
  var selectedSize = document.getElementById('selectedSize').innerText;
  var color = document.getElementById('color').innerText;
  var product_image = document.getElementById('product_image').innerText;
  var product_name = document.getElementById('product_name').innerText;
  if (selectedSize === "") {
      alert("Please select a size before proceeding to checkout.");
      return;
  }
  var selectedQuantity = document.getElementById('selectedQuantity').innerText;
  var url = "checkout.php?" +
            "size=" + encodeURIComponent(selectedSize) +
            "&quantity=" + encodeURIComponent(selectedQuantity) +
            "&description=" + encodeURIComponent(description) +
            "&product_ids=" +encodeURIComponent(product_ids)+
            "&color="+ encodeURIComponent(color)+
            "&product_image=" + encodeURIComponent(product_image) +
            "&product_name=" +encodeURIComponent(product_name) +
            "&price=" + encodeURIComponent(price);
  window.location.href = url;
}

function redirectToLogin() {
  window.location.href = "login.php";
}
function addToCart() {
        
        var description = document.getElementById('description').innerText;
        var discountedPrice = document.getElementById('discounted_price').innerText;
        var product_ids = document.getElementById('product_ids').innerText;
        var selectedSize = document.getElementById('selectedSize').innerText;
        var color = document.getElementById('color').innerText;
        var productImage = document.getElementById('product_image').innerText;
        var productName = document.getElementById('product_name').innerText;
        var selectedQuantity = document.getElementById('selectedQuantity').innerText;
        if (selectedSize === "") {
        alert("Please select a size before proceeding to checkout.");
        return;
    }

        // Send an AJAX request to insert data into the database
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Successfully added to cart!");
            }
        };
        xhttp.open("POST", "insert_order_detail.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("size=" + encodeURIComponent(selectedSize) +
                   "&quantity=" + encodeURIComponent(selectedQuantity) +
                   "&description=" + encodeURIComponent(description) +
                   "&product_ids=" +encodeURIComponent(product_ids)+
                   "&color=" + encodeURIComponent(color) +
                   "&product_image=" + encodeURIComponent(productImage) +
                   "&product_name=" + encodeURIComponent(productName) +
                   "&discounted_price=" + encodeURIComponent(discountedPrice));
    }


</script>
      </div> 
      <!-- for size  -->
      
      

    </div>
    
  </div>
  
</div>

<!-- Footer Section -->
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
</div>
<!-- Icon Links -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- Bootstrap Links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
