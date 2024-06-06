<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "collab_main";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check for empty fields
function isFormValid($fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return false;
        }
    }
    return true;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Check for empty fields
    if (!isFormValid([$name, $email, $phone, $message])) {
        echo "<script>alert('All fields are required.'); window.location.href = 'contactus.php';</script>";
    } else {
        // Sanitize form data to prevent SQL injection
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $message = mysqli_real_escape_string($conn, $message);

        // Insert data into the database
        $query = "INSERT INTO message (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
        if (mysqli_query($conn, $query)) {
            // Data inserted successfully
            echo "<script>
                    // Get the modal
                    var modal = document.getElementById('myModal');

                    // Display the modal
                    modal.style.display = 'block';

                    // Close the modal after 3 seconds
                    setTimeout(function(){
                        modal.style.display = 'none';
                        window.location.href = 'contactus.php';
                    }, 3000);
                  </script>";
        } else {
            // Error inserting data
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LUGAA | Contact Form</title>
    <link rel="stylesheet" href="css/contact.css" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <span class="big-circle"></span>
        <img src="img/shape.png" class="square" alt="" />
        <div class="form">
            <div class="contact-info">
                <a href="indexLoggedin.php" class="icon-close">
                    <ion-icon name="close-outline"></ion-icon>
                </a>
                <h3 class="title">Let's get in touch</h3>
                <p class="text">
                    Luga: Your ultimate online shopping destination. Explore curated collections across fashion.
                </p>

                <div class="info">
                    <div class="information">
                        <img src="images/location.png" class="icon" alt="" />
                        <p>Kathmandu, Nepal</p>
                    </div>
                    <div class="information">
                        <img src="images/email.png" class="icon" alt="" />
                        <p>lugaaclothing@gmail.com</p>
                    </div>
                    <div class="information">
                        <img src="images/phone.png" class="icon" alt="" />
                        <p>9876543210</p>
                    </div>
                </div>

                <div class="social-media">
                    <p>Connect with us :</p>
                    <div class="social-icons">
                        <a href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <span class="circle one"></span>
                <span class="circle two"></span>

                <form action="contactus.php" method="post" autocomplete="off">
                    <h3 class="title">Contact us</h3>
                    <div class="input-container">
                        <input type="text" name="name" class="input" required />
                        <label for="">Username</label>
                        <span>Username</span>
                    </div>
                    <div class="input-container">
                        <input type="email" name="email" class="input" required />
                        <label for="">Email</label>
                        <span>Email</span>
                    </div>
                    <div class="input-container">
                        <input type="tel" name="phone" class="input" required />
                        <label for="">Phone</label>
                        <span>Phone</span>
                    </div>
                    <div class="input-container textarea">
                        <textarea name="message" class="input" required></textarea>
                        <label for="">Message</label>
                        <span>Message</span>
                    </div>
                    <input type="submit" value="Send" class="btn" />
                </form>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Thank you! Your message has been sent.</p>
        </div>
    </div>

    <script src="js/contact.js"></script>
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName('close')[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
