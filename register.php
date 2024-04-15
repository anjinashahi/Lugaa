<!-- php code -->
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "colab_test";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
} else{
    echo"Connected successfully!";
}
if(isset($_POST['submit'])){
    $fullname = $_POST["fullname"];
    $phonenumber = $_POST["phonenumber"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    $query = "INSERT INTO users_test2(fullname, phonenumber, email, password, confirmpassword) VALUES('$fullname', '$phonenumber', '$email', '$password', '$confirmpassword')";
    mysqli_query($conn, $query);

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="wrapper">
        <a href="index.html" class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </a>
        <div class="form-box register">
            <h2>Registration</h2>
            <form class="" action="" method="post" autocomplete="off">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name = "fullname" id = "password" required>
                    <label>Fullname</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="call"></ion-icon>
                    </span>
                    <input type="phonenumber"  name = "phonenumber" id = "phonenumber" required>
                    <label>Phone number</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="email" id="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" id="password" required>
                    <label>Password</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="confirmpassword" id="confirmpassword" required>
                    <label>Confirm Password</label>
                </div>
                <div class="remember-forget">
                    <label><input type="checkbox">
                        I agree to the terms & conditions
                    </label>
                </div>
                <button type="submit" name="submit" id="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account?
                        <a href="login.html" class="login-link">
                            Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
