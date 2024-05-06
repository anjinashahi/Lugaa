<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <?php 
    session_start(); // Start the session if not already started

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "colab_test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    if(isset($_SESSION['logged'])) {
        $loggedInEmail = $_SESSION['logged'];

        // Fetch user information from the database based on the logged-in email
        $sql = "SELECT * FROM users_test2 WHERE email = '$loggedInEmail'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found, display user information
            $row = $result->fetch_assoc();
    ?>
    <div>
        <h2>User Profile</h2>
        <form method="post" action="update_profile.php">
            <p><strong>Full Name:</strong> <input type="text" name="fullname" value="<?php echo $row['fullname']; ?>"></p>
            <p><strong>Phone:</strong> <input type="text" name="phonenumber" value="<?php echo $row['phonenumber']; ?>"></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Password:</strong> <input type="password" name="password" value="<?php echo $row['password']; ?>"></p>
            <p><strong>Confirm Password:</strong> <input type="password" name="confirmpassword" value="<?php echo $row['confirmpassword']; ?>"></p>
            <p><strong>Location:</strong> <input type="text" name="location" value="<?php echo $row['location']; ?>"></p>
            <input type="submit" value="Update">
        </form>
    </div>
    <div class="home"><a href="indexLoggedin.php"><button>Home</button></a></div>
    <div class="logged-out"><a href="index.php"><button>Log Out</button></a></div>
    <?php
        } else {
            echo "User not found.";
        }
    } else {
        echo "User not logged in.";
    }

    $conn->close(); // Close the database connection
    ?>
</body>
</html>
