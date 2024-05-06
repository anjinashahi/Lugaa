<?php
session_start(); // Start the session if not already started

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collab_main";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

if(isset($_SESSION['logged'])) {
    $loggedInEmail = $_SESSION['logged'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect user input from the form
        $fullname = $_POST['full_name'];
        $phone = $_POST['phone_number'];
        $password = $_POST['password'];
        $location = $_POST['address'];

        // Update the user's information in the database
        $sql = "UPDATE customers SET full_name='$fullname',phone_number ='$phone', password='$password', address='$location' WHERE email='$loggedInEmail'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record Updated successfully');</script>";
           
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "User not logged in.";
}

$conn->close(); // Close the database connection
?>
