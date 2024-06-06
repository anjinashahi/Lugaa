<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./message.css">
    <link rel="stylesheet" href="./seller.css">

</head>
<body>
    <div class="main-container">
        <div class="left">
            <nav>
                <ul class="">
                    <li class="admin-login">
                        <div class="admin-info">
                            <div class="admin-photo">
                                <!-- <img src="admin.webp" alt="Admin Photo"> -->
                            </div>
                            <div class="admin-name">Hello, Admin</div>
                        </div>
                        <li> <a href="analytics.php">Analytics</a></li>
                        <li> <a href="seller.php">Seller</a></li>
                        <li> <a href="product.php">Product</a></li>
                        <li> <a href="finance.php">Finance</a></li>
                        <li> <a href="message.php">Message</a></li>
                        <li> <a href = "logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Right Sidebar -->
        <div class="right">
            <?php
            include 'session_check.php';
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "collab_main";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Handle message deletion
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message_id"])) {
                $message_id = $_POST["message_id"];
                $sql = "DELETE FROM message WHERE id = '$message_id'";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Message deleted successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error deleting message: " . $conn->error . "</div>";
                }
            }

            // Retrieve data from the message table
            $sql = "SELECT * FROM message ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Messaged At</th><th>Action</th></tr></thead><tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["phone"]."</td>";
                    echo "<td>".$row["message"]."</td>";
                    echo "<td>".$row["created_at"]."</td>";
                    echo "<td><form method='post'><input type='hidden' name='message_id' value='".$row["id"]."'><button type='submit' class='btn btn-danger'>Delete</button></form></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "No messages found";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
