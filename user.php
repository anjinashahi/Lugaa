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
    <link rel="stylesheet" href="css/user.css">
    <style>
        .popup-section {
            display: none;
        }
    </style>
</head>

<body>
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
            
            
            echo "Color: " . $row["color"]. "<br>";
            echo "Quantity: " . $row["quantity"]. "<br>";
            echo "Size: " . $row["size"]. "<br>";
            echo "Total: " . $row["total"]. "<br>";
            // echo "Order Status: " . $row["order_status"]. "<br>";
            // echo "Single Price: " . $row["singlePrice"]. "<br>";
            // echo "Order Pending: " . $row["order_pending"]. "<br>";
            // echo "Order Completed: " . $row["order_completed"]. "<br>";
            // echo "Product ID: " . $row["product_id"]. "<br>";
            // echo "Order IDS  ";
            // echo "Order ID: " . $row["order_id"]. "<br>";
            // echo "Customer ID: " . $customer_id. "<br>";
            // echo "Address: " . $row["address"]. "<br>";
            // echo "Phone: " . $row["phone"]. "<br>";
            echo "Image: <img src='img/" . $row["image"] . "' alt=''><br><br><br>";

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
