<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="CSS/user.css">
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
                <div class="dropdown">
                    <button id="edit-profile-btn" class="dropbtn">Edit Profile</button>
                </div>
                <section id="edit-profile" class="popup-section">
                    <div id="edit-profile-form" class="popup-content">
                        <form id="edit-profile-form" action="update_profile.php" method="POST">
                            <?php
                            // Fetch user data from database
                            $servername = "localhost";
                            $username = "localhost";
                            $password = "root";
                            $dbname = "collab_main";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $user_id = 1; // Assuming user ID is 1, you may change it as needed
                            $sql = "SELECT * FROM customers WHERE customer_id = $user_id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of the first row
                                $row = $result->fetch_assoc();
                                echo "<label for='name'>Name:</label><br>";
                                echo "<input type='text' id='name' name='name' value='" . $row["full_name"] . "'><br>";
                                echo "<label for='location'>Location:</label><br>";
                                echo "<input type='text' id='location' name='location' value='" . $row["address"] . "'><br>";
                                echo "<label for='email'>Email:</label><br>";
                                echo "<input type='email' id='email' name='email' value='" . $row["email"] . "'><br>";
                                echo "<label for='phone'>Phone:</label><br>";
                                echo "<input type='tel' id='phone' name='phone' value='" . $row["phone_number"] . "'><br>";
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                            ?>
                            <button type="submit">Save Changes</button>
                        </form>
                    </div>
                </section>
            </section>

            <section id="order-history">
                <h2>Order History</h2>
                <ul>
                    <li>Order #1234 - Product A, Product B</li>
                    <li>Order #5678 - Product C</li>
                    <li>Order #91011 - Product D, Product E, Product F</li>
                </ul>
            </section>
            <section id="refund">
                <h2>Refund Status</h2>
                <ul>
                    <li>Order #1234 - Product A, Product B</li>
                    <li>Order #5678 - Product C</li>
                    <li>Order #91011 - Product D, Product E, Product F</li>
                </ul>
            </section>
            <section id="logout">
                <h2></h2>
                <button>Logout</button>
            </section>
        </div>

    </div>
    <script src="js/user.js"></script>
</body>

</html>
