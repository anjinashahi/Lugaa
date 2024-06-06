<?php
session_start(); // Start the session if not already started

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collab_main";

require 'connection.php';

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
        $userData = $result->fetch_assoc();
        $customer_id = $userData['customer_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="user.css">
    <!-- <link rel="stylesheet" href="css/main.css"> -->
    <style>
                .popup-section {
                    display: none;
                }

                /* Navigation Bar */
                .header {
                    background: #D9D9D9;
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    width: 100%;
                    box-sizing: border-box;
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    z-index: 100;
                }

                .logo {
                    border-radius: 25px;
                    width: 250px;
                    height: 100px;
                    overflow: hidden;
                    object-fit: cover;
                }

                .logo img {
                    height: 100%;
                    border-radius: 25px;
                }

                .nav {
                    display: flex;
                    flex-direction: row;
                    justify-content: space-around;
                    height: fit-content;
                    box-sizing: border-box;
                }

                .nav a {
                    text-decoration: none;
                    color: #000000;
                }

                .nav span {
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    cursor: pointer;
                    transition: transform 0.3s ease;
                }

                .nav span:hover {
                    transform: scale(1.1);
                }

                .nav-bar {
                    margin-bottom: 8px;
                    flex-direction: row;
                    justify-content: center;
                    box-sizing: border-box;
                }

                .line-1 {
                    background: #000000;
                    align-self: center;
                    width: 325px;
                    height: 1px;
                }

                .topright {
                    display: flex;
                    align-items: center;
                }

                .search,
                .cart-group,
                .usericon {
                    margin-right: 20px;
                    font-size: 24px;
                }

                .search ion-icon,
                .cart-group ion-icon,
                .usericon ion-icon {
                    cursor: pointer;
                }

                /* Footer */
                .footer {
                    background: #D9D9D9;
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 20px 108px;
                    width: 100%;
                    box-sizing: border-box;
                }

                .instagram-1 {
                    margin: 0 19px 1px 0;
                    width: 24px;
                    height: 24px;
                }

                .facebook-1 {
                    margin-top: 1px;
                    width: 24px;
                    height: 24px;
                }

                .instagram-1 img,
                .facebook-1 img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .line-2 {
                    background: #000000;
                    width: 450px;
                    height: 1px;
                    align-self: center;
                }

                .logo-1 {
                    border-radius: 40px;
                    position: absolute;
                    left: 0px;
                    bottom: 0px;
                    width: 80px;
                    height: 80px;
                }

                .logo-1 img {
                    border-radius: 40px;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .a-new-style-everyday-2 {
                    position: relative;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .footerlogo {
                    position: relative;
                    margin: 9px 0 42px 0;
                    display: flex;
                    flex-direction: row;
                    justify-content: center;
                    padding: 50px 0 16px 0;
                    box-sizing: border-box;
                }

                .contact {
                    display: flex;
                    flex-direction: column;
                    box-sizing: border-box;
                }

                .stayconnected {
                    margin-bottom: 59px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    box-sizing: border-box;
                }

                .contact-us-3 {
                    margin: 0 0 21px 10.4px;
                    display: inline-block;
                    align-self: center;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .stay-connected {
                    margin-bottom: 33px;
                    display: inline-block;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .pin-1 {
                    margin: 5px 23px 0 0;
                    width: 20px;
                    height: 20px;
                }

                .pin-1 img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .phone-call-1 {
                    margin: 6px 23px 0 0;
                    width: 20px;
                    height: 20px;
                }

                .phone-call-1 img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .email-1 {
                    position: relative;
                    margin: 6px 23px 0 0;
                    width: 20px;
                    height: 20px;
                }

                .email-1 img {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .kathmandu-nepal {
                    margin-bottom: 11px;
                    display: inline-block;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .phonenumber {
                    margin-bottom: 12px;
                    display: inline-block;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .lugaagmail-com {
                    margin-bottom: 12px;
                    display: inline-block;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .copyright-1 {
                    margin: 8px 3px 0 0;
                    width: 15px;
                    height: 15px;
                }

                .copyright-1 img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .lugaa {
                    margin-bottom: 9px;
                    display: inline-block;
                    overflow-wrap: break-word;
                    font-family: 'Sans Serif Collection', 'Roboto Condensed';
                    font-weight: 400;
                    font-size: 12px;
                    color: #000000;
                }

                .container-6 {
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-self: center;
                    width: 100%;
                    box-sizing: border-box;
                }

                .container-7 {
                    margin-bottom: 10px;
                    display: flex;
                    flex-direction: row;
                    width:
                }
            </style>

</head>

<body>
<div class="header">
                <div class="logo">
                    <img src="images/logo221.png" alt="Logo">
                </div>
                <div class="nav-bar">
                    <div class="nav">
                        <a href="indexLoggedin.php"><span>Home</span></a>
                        <a href="product_page.php"><span>Products</span></a>
                        <a href="contactus.php"><span>Contact Us</span></a>
                    </div>
                    <div class="line-1"></div>
                </div>
                <div class="topright">
                    <div class="cart-group">
                        <?php
                        if (isset($_SESSION['logged'])) {
                            echo '<a href="cart_test.php"><ion-icon name="cart-outline"></ion-icon></a>';
                        } else {
                            echo '<a href="login.php"><ion-icon name="cart-outline"></ion-icon></a>';
                        }
                        ?>
                    </div>
                    <div class="usericon">
                        <?php
                        if (isset($_SESSION['logged'])) {
                            echo '<a href="user.php"><ion-icon name="person-circle-outline"></ion-icon></a>';
                        } else {
                            echo '<a href="login.php"><ion-icon name="person-circle-outline"></ion-icon></a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
    <header>
        <h1>User Profile</h1>
    </header>
    <div class="container">
        <div class="profile-section">
            <section id="user-profile">
                <h2>User Profile</h2>
                <img src="images/user-2.png" alt="Profile Picture" width="100"><br>
                <p>Name: <?php echo $userData['full_name']; ?></p>
                <p>Email: <?php echo $userData['email']; ?></p>
                <p>Address: <?php echo $userData['address']; ?></p>
                <p>customer: <?php echo $customer_id;?></p>
                <p>Phone Number: <?php echo $userData['phone_number']; ?></p>
                <div class="dropdown">
                    <button id="edit-profile-btn" class="dropbtn">Edit Profile</button>
                </div>
                <section id="edit-profile" class="popup-section">
            <div id="edit-profile-form" class="popup-content">
            <form id="edit-profile-form" method="post" action="update_profile.php" enctype="multipart/form-data">
            <label for="profile-image">Profile Image:</label><br>
            <input type="file" id="profile-image" name="customer_image" accept=".jpg, .jpeg, .png"><br>

            <label for="full_name">Name:</label><br>
            <input type="text" id="full_name" name="full_name" value="<?php echo $userData['full_name']; ?>"><br>

            <label for="user_name">User Name:</label><br>
            <input type="text" id="user_name" name="user_name" value="<?php echo $userData['username']; ?>"><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" value="<?php echo $userData['address']; ?>"><br>

            <label for="phone">Phone:</label><br>
            <input type="text" id="phone" name="phone" value="<?php echo $userData['phone_number']; ?>"><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="<?php echo $userData['password']; ?>"><br>

            <button type="submit" name="submit">Save Changes</button>
        </form>
    </div>
</section>

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

            <section id="order-history">
                <h2>Order History</h2>
                <ul>
                <?php
                    $sql = "SELECT * FROM order_details WHERE customer_id = '$customer_id'";
                    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class = 'order_box'>";
            
            echo"<div class ='order-info'>";
            echo "Color: " . $row["color"]. "<br>";
            echo "Quantity: " . $row["quantity"]. "<br>";
            echo "Size: " . $row["size"]. "<br>";
            echo "Order ID: " . $row["order_id"]. "<br>";
            // echo "Total: " . $row["total"]. "<br>";
            echo "</div>";
            // echo "Order Status: " . $row["order_status"]. "<br>";
            // echo "Single Price: " . $row["singlePrice"]. "<br>";
            // echo "Order Pending: " . $row["order_pending"]. "<br>";
            // echo "Order Completed: " . $row["order_completed"]. "<br>";
            // echo "Product ID: " . $row["product_id"]. "<br>";
            // echo "Order IDS  ";
           
            // echo "Customer ID: " . $customer_id. "<br>";
            // echo "Address: " . $row["address"]. "<br>";
            // echo "Phone: " . $row["phone"]. "<br>";
            // echo "<img src='img/" . $row["image"] . "' alt=''><br><br><br>";
            
            echo "</div>";
        }
    } else {
        echo "0 results";
    }
?>







                    
                </ul>
            </section>
            <section id="logout">
                <h2></h2>
                <form action="logout.php" method="post">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </section>
        </div>
    </div>
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
                    <div class="lugaagmail-com">lugaaclothung@gmail.com</div>
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
            <div class="lugaa-all-rights">2023 Lugaa. All Rights Reserved</div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editProfileBtn = document.getElementById("edit-profile-btn");
            var editProfileSection = document.getElementById("edit-profile");
            var editProfileForm = document.getElementById("edit-profile-form");

            // Show popup section when the button is clicked
            editProfileBtn.addEventListener("click", function() {
                editProfileSection.style.display = "block";
                editProfileForm.style.display = "block";
            });

            // Hide popup section when clicking outside of it
            window.addEventListener("click", function(event) {
                if (event.target !== editProfileBtn && !editProfileForm.contains(event.target)) {
                    editProfileSection.style.display = "none";
                    editProfileForm.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>
