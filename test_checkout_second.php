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
        <!-- Customer Information Section -->
        <section class="customer-info">
          <h2>Customer Information</h2>
          <form>
            <div>
              <label for="fullname">Full Name:</label>
              <input type="text" id="fullname" name="fullname" required>
            </div>
            <div>
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div>
              <label for="phone">Phone Number:</label>
              <input type="tel" id="phone" name="phone" required>
            </div>
          </form>
        </section>

        <!-- Delivery Information Section -->
        <section class="delivery-info">
          <h2>Delivery Information</h2>
          <form>
            <div>
              <label for="city">City:</label>
              <input type="text" id="city" name="city" required>
            </div>
            <div>
              <label for="address">Address:</label>
              <input type="text" id="address" name="address" required>
            </div>
            <div>
              <label for="landmark">Nearest Landmark:</label>
              <input type="text" id="landmark" name="landmark">
            </div>
          </form>
        </section>
      </div>

      <div class="os">
        <!-- Order Summary Section -->
        <section class="order-summary">
          <h2>Order Summary</h2>
          <div class="product">
            <img src="images/i1.jpeg" alt="Product Image">
            <div>
              <h3>Product Name</h3>
              <!-- Add more product details here if needed -->
            </div>
          </div>
          <div>
            <p>Subtotal: $50.00</p>
            <p>Discount: $5.00</p>
            <h3>Total: $45.00</h3>
          </div>
          <button class="place-order">Place Order</button>
        </section>
      </div>
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
