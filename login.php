<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>


<!-- php code -->
<?php
// Establish a connection to your database
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "collab_main"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo '<script>console.log("Connected successfully!")</script>'; // Debugging statement
}

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Fetch email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a SQL query to check if the email and password exist in the 'customer' table
    $sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    
    session_start();

    if ($result->num_rows > 0) {
        // User authenticated successfully
        // Redirect to a dashboard or set session variables (if needed)
        $row = $result->fetch_assoc();
        $fullname =$row["full_name"];
        $customer =$row["customer_id"];
        $address =$row["address"];
        $phone =$row["phone"];
        
        $_SESSION["logged"]=$fullname;
        $_SESSION["customer"] = $customer_id;
        $_SESSION["address"] = $address;
        $_SESSION["phone"] = $phone;
        header("Location: indexLoggedin.php?name=" . urlencode($fullname)); 
    } else {
        // Invalid login credentials
        echo "<script>alert('Invalid email or password.');</script>";
    }
}

// Close the database connection
$conn->close();
?>



<body>
    <div class="wrapper">
        <a href="indexLoggedin.php" class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </a>
        <div class="form-box login">
            <h2>Login</h2>
           <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name = "email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="text" name = "password" id = "password" required value = "">
                    <label>Password</label>
                </div>
                <div class="remember-forget">
                    <label><input type="checkbox"> Remember me </label>
                    <a href="#">Forget Password?</a>
                </div>
                <button type="submit" name="submit" class = "btn">Submit</button>
                <div class="login-register">
                    <p>Don't have an account?
                        <a href="register.php" class="register-link">
                            Register
                        </a>
                    </p>
                </div>
            </form>
            <div class="google-signin">
    <!-- Start of the sign in php code  -->
    Sign in with Google
        </div>
    </div>


    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>