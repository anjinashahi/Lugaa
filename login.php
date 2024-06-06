<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .input-box {
            position: relative;
            margin-bottom: 20px;
        }
        
        .toggle-password {
            position: absolute;
            right: 30px; /* 10px to the left from the edge of the input */
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #000; /* Black color */
        }
        
        .error-message {
            color: red;
            font-size: 0.875em;
            position: absolute;
            top: 100%;
            left: 0;
        }
    </style>
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

// Initialize error message variable
$error_message = '';

// Check if form is submitted
if (isset($_POST['submit'])) {
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
        $fullname = $row["full_name"];
        $customer = $row["customer_id"];
        $address = $row["address"];
        $phone = $row["phone"];
        
        $_SESSION["logged"] = $fullname;
        $_SESSION["customer"] = $customer;
        $_SESSION["address"] = $address;
        $_SESSION["phone"] = $phone;
        header("Location: indexLoggedin.php?name=" . urlencode($fullname));
    } else {
        // Invalid login credentials
        $error_message = "Invalid email or password.";
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
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" id="password" required>
                    <label>Password</label>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="far fa-eye" id="eye-icon"></i>
                    </span>
                    <?php if ($error_message): ?>
                        <span class="error-message"><?php echo $error_message; ?></span>
                    <?php endif; ?>
                </div>
                <button type="submit" name="submit" class="btn">Submit</button>
                <div class="login-register">
                    <p>Don't have an account?
                        <a href="register.php" class="register-link">
                            Register
                        </a>
                    </p>
                </div>
            </form>
            <!-- <div class="google-signin">
                Start of the sign in php code  -->
                <!-- Sign in with Google
             </div> --> 
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>