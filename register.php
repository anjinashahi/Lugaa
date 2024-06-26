<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collab_main";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connected successfully!";
}

$error_message = '';

if (isset($_POST['submit'])) {
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $phonenumber = $_POST["phonenumber"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $address = $_POST["address"];

    if ($password !== $confirmpassword) {
        $error_message = "Passwords do not match.";
    } else {
        $query = "INSERT INTO customers(username, full_name, phone_number, email, password, address) VALUES('$username','$fullname', '$phonenumber', '$email', '$password', '$address')";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Registered successfully!"); window.location.href = "login.php";</script>';
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
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

<body>
    <div class="wrapper">
        <a href="index.html" class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </a>
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="" method="post" autocomplete="off">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name="fullname" required>
                    <label>Fullname</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="call"></ion-icon>
                    </span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="location"></ion-icon>
                    </span>
                    <input type="text" name="address" required>
                    <label>Address</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="call"></ion-icon>
                    </span>
                    <input type="text" name="phonenumber" required>
                    <label>Phone number</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" id="password" required>
                    <label>Password</label>
                    <span class="toggle-password" onclick="togglePassword('password', 'eye-icon1')">
                        <i class="far fa-eye" id="eye-icon1"></i>
                    </span>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="confirmpassword" id="confirmpassword" required>
                    <label>Confirm Password</label>
                    <span class="toggle-password" onclick="togglePassword('confirmpassword', 'eye-icon2')">
                        <i class="far fa-eye" id="eye-icon2"></i>
                    </span>
                    <?php if ($error_message): ?>
                        <span class="error-message"><?php echo $error_message; ?></span>
                    <?php endif; ?>
                </div>
                
                <button type="submit" name="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account?
                        <a href="login.php" class="login-link">
                            Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePassword(fieldId, eyeIconId) {
            var passwordField = document.getElementById(fieldId);
            var eyeIcon = document.getElementById(eyeIconId);
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>