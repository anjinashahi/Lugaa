<!DOCTYPE html>
<html lang="en">
<?php 
require 'connection.php';


?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lugaa | Product</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/product.css">
  <script src="js/product.js" defer></script>
</head>

<body>

  <!-- Header Section -->
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

  <div class="container">
    <!-- Filter Section -->
    <div class="filter-panel">
      <h2>Filter</h2>
      <form id="filter-form">
        <div class="filter-group">
          <h3>Category:</h3>
          <div class="filter-option">
            <input type="checkbox" id="category-Top" name="category" value="shirts">
            <label for="category-shirts">Shirts</label>
          </div>
          <div class="filter-option">
            <input type="checkbox" id="category-Bottom" name="category" value="pants">
            <label for="category-pants">Pants</label>
          </div>
          <div class="filter-option">
            <input type="checkbox" id="category-" name="category" value="dresses">
            <label for="category-dresses">Dresses</label>
          </div>
        </div>
        <div class="filter-group">
          <h3>Size:</h3>
          <div class="filter-options">
            <div class="filter-option">
              <input type="checkbox" id="size-s" name="size" value="s">
              <label for="size-s">S</label>
            </div>
            <div class="filter-option">
              <input type="checkbox" id="size-m" name="size" value="m">
              <label for="size-m">M</label>
            </div>
            <div class="filter-option">
              <input type="checkbox" id="size-l" name="size" value="l">
              <label for="size-l">L</label>
            </div>
            <div class="filter-option">
              <input type="checkbox" id="size-xl" name="size" value="xl">
              <label for="size-xl">XL</label>
            </div>
          </div>
        </div>

        <div class="filter-group">
          <h3>Color:</h3>
          <div class="filter-option">
            <input type="checkbox" id="color-red" name="color" value="red">
            <label for="color-red">Red</label>
          </div>
          <div class="filter-option">
            <input type="checkbox" id="color-blue" name="color" value="blue">
            <label for="color-blue">Blue</label>
          </div>
          <div class="filter-option">
            <input type="checkbox" id="color-green" name="color" value="green">
            <label for="color-green">Green</label>
          </div>
        </div>
        <div class="filter-group">
          <h3>Price Range:</h3>
          <input type="range" id="price" name="price" min="0" max="100" value="0">
          <p>Price: <span id="price-value">$0</span></p>
        </div>
        <button type="submit">Apply Filters</button>
      </form>
    </div>
    <!-- Product Section -->
    <section class= "product">
    <?php $result = mysqli_query($conn, "SELECT * FROM product ORDER BY product_id DESC");
    while ($row = mysqli_fetch_assoc($result)) :?>
    <div class="product-section">
      <h2 class="title">Products</h2>
      <div class="product-row">
        <div class="product" data-name="p-1">
        <img src="img/<?php echo $row['image']; ?>" alt="">
          <h3><?php echo $row["product_name"]; ?></h3>
          <p ><?php echo $row["price"]; ?></p>
          
        </div>
        <?php endwhile; ?>
        <!-- <div class="product" data-name="p-2">
          <img src="images/i3.jpeg" alt="Product 2">
          <h3>Hoodie</h3>
          <p class="price">$29.99</p>

        </div>
        <div class="product" data-name="p-3">
          <img src="images/i1.jpeg" alt="Product 3">
          <h3>SweatShirt</h3>
          <p class="price">$24.99</p>

        </div>
        <div class="product" data-name="p-4">
          <img src="images/i3.jpeg" alt="Product 4">
          <h3>Hoodie</h3>
          <p class="price">$39.99</p>

        </div>
        <div class="product" data-name="p-5">
          <img src="images/i1.jpeg" alt="Product 5">
          <h3>SweatShirt</h3>
          <p class="price">$49.99</p>

        </div>
        <div class="product" data-name="p-6">
          <img src="images/i3.jpeg" alt="Product 5">
          <h3>Hoodie</h3>
          <p class="price">$49.99</p>

        </div>
        <div class="product" data-name="p-7">
          <img src="images/i1.jpeg" alt="Product 5">
          <h3>SweatShirt</h3>
          <p class="price">$49.99</p>

        </div>
        <div class="product" data-name="p-8">
          <img src="images/i3.jpeg" alt="Product 5">
          <h3>Hoodie</h3>
          <p class="price">$49.99</p>

        </div> -->
      </div>
      </section>
    <!-- Product Preview Section -->
      <div class="products-preview">
      <div class="preview" data-target="p-1">
        <i class="fas fa-times"></i>
        <img src="images/i1.jpeg" alt="">
        <h3>SweatShirt</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>

      <div class="preview" data-target="p-2">
        <i class="fas fa-times"></i>
        <img src="images/i3.jpeg" alt="">
        <h3>Hoodie</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>

      <div class="preview" data-target="p-3">
        <i class="fas fa-times"></i>
        <img src="images/i1.jpeg" alt="">
        <h3>SweatShirt</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>

      <div class="preview" data-target="p-4">
        <i class="fas fa-times"></i>
        <img src="images/i3.jpeg" alt="">
        <h3>Hoodie</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>

      <div class="preview" data-target="p-5">
        <i class="fas fa-times"></i>
        <img src="images/i1.jpeg" alt="">
        <h3>SweatShirt</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>

      <div class="preview" data-target="p-6">
        <i class="fas fa-times"></i>
        <img src="images/i3.jpeg" alt="">
        <h3>Hoodie</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>
      <div class="preview" data-target="p-7">
        <i class="fas fa-times"></i>
        <img src="images/i1.jpeg" alt="">
        <h3>SweatShirt</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>
      <div class="preview" data-target="p-8">
        <i class="fas fa-times"></i>
        <img src="images/i3.jpeg" alt="">
        <h3>Hoodie</h3>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>( 250 )</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
        <div class="price">$2.00</div>
        <div class="buttons">
          <a href="#" class="buy">buy now</a>
          <a href="#" class="cart">add to cart</a>
        </div>
      </div>
      </div>
    </div>
    <!-- Icon Links -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </div>
</body>

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

</html>