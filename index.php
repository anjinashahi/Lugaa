```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````` <!DOCTYPE html>
<html lang="en">
<?php 
require 'connection.php';


?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lugaa | Clothing Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div class="home-page">
        <!-- Header Section -->


        <!-- php code for products  -->
        
        <div class="header">
            <div class="logo">
                <img src="images/logo221.png" alt="Logo">
            </div>
            <div class="nav-bar">
                <div class="nav">
                    <a href="index.php"><span>
                     Home
                    </span></a>
                    <a href="product_page.php"><span>
                        Products
                    </span></a>
                    <a href="contactus.html"><span>
                        Contact Us
                    </span></a>
                    
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
                    <a href="login.php">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </a>
                </div>
            </div>
        </div>
        <section class="main-section">
            <!-- Catchphrase Section -->
            <div class="catchphrase">
                <p>A New Style Everyday</p>
            </div>

            <!-- carousel -->
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="10000">
                    <img src="images/Banner/b1.png" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                    <img src="images/Banner/b2.png" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="images/Banner/b3.png" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>




            <!-- Discounted Section  -->
            <div class="discounted-section"> 
                <h2>Discounted Products</h2>
                <section class="discount_container">
                <?php 
                $result = mysqli_query($conn, "SELECT * FROM discounted_product ORDER BY product_id DESC");
                while ($row = mysqli_fetch_assoc($result)) :?>
                <div class="product">
                <img src="img/<?php echo $row['image']; ?>" alt="">
                <div class="details">
                        <h3><?php echo $row["product_name"]; ?></h3>
                        <p class="original-price"><?php echo $row["actual_price"]; ?></p>
                        <p class="discounted-price"><?php echo $row["discounted_price"]; ?></p>
                        <p><?php //echo $row["quantity"]; ?></p>
                        <button class="buy-button">Buy Now</button>
                    </div>
                </div>
                <?php endwhile; ?>
                </section>
                
                </div>
                <!-- Latest Section -->
                <div class="lastest">
                    <h2>New Arrivals</h2>
                    <section class="newarrival_container"> 
                <?php 
                $result = mysqli_query($conn, "SELECT * FROM product ORDER BY product_id DESC");
                while ($row = mysqli_fetch_assoc($result)) :?>
                <div class="product">
                <img src="img/<?php echo $row['image']; ?>" alt="">
                <div class="details">
                        <h3><?php echo $row["product_name"]; ?></h3>
                        <p><?php echo $row["price"]; ?></p>
                        
                        <button class="buy-button">Buy Now</button>
                    </div>
                </div>
                <?php endwhile; ?>
                </section>
                        <!-- <div class="p">
                            <img src="images/image2.jpeg" alt="Hoodie (Black)">
                            <div class="product-info">
                                <p>Hoodie (Black)</p>
                                <p>Rs 2,000.00</p>
                                <button class="buy-button">Buy Now</button>
                            </div>
                        </div>
                        <div class="p">
                            <img src="images/image3.jpeg" alt="Joggers (Grey)">
                            <div class="product-info">
                                <p>Joggers (Grey)</p>
                                <p>Rs 2,000.00</p>
                                <button class="buy-button">Buy Now</button>
                            </div>
                        </div> -->
                    </div>
                </div>
                
                <!-- About Section -->
                <div class="aboutsection">
                    <div class="astext">
                        <h2>About Us</h2>
                        <p>
                            &#34;Luga: Your ultimate online shopping destination. Explore curated collections across
                            fashion,
                            electronics, home goods, and more. Our sleek design and intuitive features ensure a seamless
                            browsing experience. Discover convenience, style, and satisfaction with Luga.&#34;
                        </p>
                    </div>
                    <div class="modeling">
                        <img src="images/modeling.jpeg" alt="model">
                    </div>
                </div>
                <!-- Review Section -->
                <div class="review-form-container">
                    <h2>Leave a Review</h2>
                    <form id="review-form">
                        <div class="form-group">
                            <label for="name">Your Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <select id="rating" name="rating" required>
                                <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                                <option value="4">&#9733;&#9733;&#9733;&#9733;&#9734;</option>
                                <option value="3">&#9733;&#9733;&#9733;&#9734;&#9734;</option>
                                <option value="2">&#9733;&#9733;&#9734;&#9734;&#9734;</option>
                                <option value="1">&#9733;&#9734;&#9734;&#9734;&#9734;</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Your Review:</label>
                            <textarea id="review" name="review" rows="4" required></textarea>
                        </div>
                        <button type="submit">Submit Review</button>
                    </form>
                </div>
                <div class="review-container">
                    <div class="review-card">
                        <img src="images/user-1.png" alt="John Doe Profile Picture">
                        <div class="review-content">
                            <div class="reviewer">John Doe</div>
                            <div class="star-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <div class="review-text">Great quality clothing, fast shipping, and excellent customer
                                service.
                                Highly recommended!</div>
                        </div>
                    </div>

                    <div class="review-card">
                        <img src="images/user-2.png" alt="Jane Smith Profile Picture">
                        <div class="review-content">
                            <div class="reviewer">Jane Smith</div>
                            <div class="star-rating">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                            <div class="review-text">I love the designs and the fabric quality, but shipping took longer
                                than expected.</div>
                        </div>
                    </div>

                    <div class="review-card">
                        <img src="images/user-3.png" alt="Michael Johnson Profile Picture">
                        <div class="review-content">
                            <div class="reviewer">Michael Johnson</div>
                            <div class="star-rating">&#9733;&#9733;&#9733;&#9734;&#9734;</div>
                            <div class="review-text">Good value for the price. However, the sizing runs a bit small, so
                                I
                                recommend ordering a size up.</div>
                        </div>
                    </div>
                </div>

        </section>
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
                            lugaa@gmail.com
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

    <!-- ending code for php -->
    
</body>

</html>

````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````