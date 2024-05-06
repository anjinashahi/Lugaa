<?php require 'connection.php'; 
?>

<?php
    // session_start(); // Start the session

    // // Display the value of product_id2 sent via POST
    // if(isset($_POST['product_id2'])) {
    //     $product_id2 = $_POST['product_id2'];
    //     echo "Product ID 2: " . $product_id2;
    //     $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id2");

    //     while ($row = mysqli_fetch_assoc($result)) {
    //         echo '
    //         <div class="product-image">
    //             <img src="img/' . $row['image'] . '" alt="Product Image">
    //         </div>
    //         <div class="product-info">
    //             <h2>' . $row["product_name"] . '</h2>
    //             <p class="description">' . $row["description"] . '</p>
                
    //             <p class="price">price:$' . $row["price"] . '</p>
  
    //         </div>';}


    // } else {
    //     echo "Product ID 2 is not set via POST request.";
    // }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Name - Lugaa</title>
  <link rel="stylesheet" href="css/p.css">
  <script src="js/p.js" defer></script>
</head>
<body>

  <!-- Header Section -->
  <div class="header">
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

  </div>
  <!-- Product Details Section -->
  <div class="container">
    <div class="product-details">
    <div class="product-info">

    <!-- fetched data from table -->
    <div class = "fetched">
<?php
session_start(); // Start the session

// Check if product_id session variable is set
if(isset($_POST['product_id2'])) {
    $product_id2 = $_POST['product_id2'];
    echo "Product ID 2: " . $product_id2;
    $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id2");
    $products_ids = $product_id2;
    if(mysqli_num_rows($result) > 0) {
      // Output fetched data
      while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <div id="product_image" style="display: none;">'. $row['image'] .'</div>
        <div class="product-image">
            <img src="img/' . $row['image'] . '" alt="Product Image">
        </div>
        <div class="product-info">
            <div id = "product_name" style="display: none;">'.$row["product_name"].' </div>
            
            <p><h2>' . $row["product_name"] . '</h2></p>
            <p id="product_ids">' . $products_ids. '</p>

            <p id = "color">'.$row["color"].'</p>
            <p class="description" id = "description">' . $row["description"] . '</p>
            <p class="price" id = "price">' . $row["price"] . '</p>
  
        </div>';
        echo"<script>console.log('Product ID:', product_id); </script>";
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
<button class="add-to-cart">Add to Cart</button>
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
</body>
</html>
