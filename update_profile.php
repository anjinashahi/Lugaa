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
    
    // Retrieve form data
    $fullName = $_POST['full_name'];
    $userName = $_POST['user_name'];
    $address = $_POST['location'];
    $phoneNumber = $_POST['phone'];
    $password = $_POST['password'];

    // File upload handling
    $newImageName = '';
    if ($_FILES["customer_image"]["error"] === 0) {
        $fileName = $_FILES["customer_image"]["name"];
        $fileSize = $_FILES["customer_image"]["size"];
        $tmpName = $_FILES["customer_image"]["tmp_name"];

        $validImageExtension = ['jpg','jpeg','png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Invalid image format');</script>";
            exit;
        } elseif ($fileSize > 100000000) {
            echo "<script>alert('Image size is too large');</script>";
            exit;
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'img/' . $newImageName);
        }
    }

    // Update user information in the database
    $sql = "UPDATE customers SET full_name = ?, username = ?, address = ?, phone_number = ?, password = ? WHERE full_name = '$loggedInEmail' ";
    $types = "sssss";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param($types, $fullName, $userName, $address, $phoneNumber, $password);
        $stmt->execute();
        $stmt->close();
        
        // If a new image was uploaded, update the image field
        if (!empty($newImageName)) {
            $sqlUpdateImage = "UPDATE customers SET image = ?";
            $stmtUpdateImage = $conn->prepare($sqlUpdateImage);
            if ($stmtUpdateImage) {
                $stmtUpdateImage->bind_param("s", $newImageName);
                $stmtUpdateImage->execute();
                $stmtUpdateImage->close();
            }
        }

        echo "<script>alert('Profile updated successfully'); document.location.href = 'user.php';</script>";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
} else {
    echo "User not logged in.";
}

$conn->close(); // Close the database connection
?>
