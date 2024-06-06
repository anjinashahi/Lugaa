<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./seller.css">
    <style>
        /* CSS for layout */
        .main-container {
            /* margin: 20px; */
        }
        .seller-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            width: 250px;
            0px; /* Adjust width as needed */
            display: inline-block;
            margin-right: 10px;
        }
        .seller-card img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
            margin-bottom: 10px;
        }
        .seller-card p {
            margin: 10px 0;
        }
        /* CSS for modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                        <li><a href="analytics.php">Analytics</a></li>
                        <li><a href="seller.php">Seller</a></li>
                        <li><a href="product.php">Product</a></li>
                        <li><a href="finance.php">Finance</a></li>
                        <li><a href="message.php">Message</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="right">
            <div class="button-nav">
                <button type="button" id="addBtn" class="btn btn-primary btn-sm">Add Seller</button>
                <button type="button" id="deleteBtn" class="btn btn-secondary btn-sm">Delete Seller</button>
            </div>
            <div id="sellerCards">
                <?php
                include 'session_check.php';
                // Include database connection
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

                // Fetch sellers from database and display as ID cards
                $sql = "SELECT * FROM seller";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='seller-card'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['photo']) . "' alt='Seller Photo'>";
                        echo "<p><strong>Username:</strong> " . $row['username'] . "</p>";
                        echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                        echo "<p><strong>Full Name:</strong> " . $row['full_name'] . "</p>";
                        echo "<p><strong>Phone Number:</strong> " . $row['phone_number'] . "</p>";
                        echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
                        echo "<p><strong>Salary:</strong> " . $row['salary'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Modal for Add Seller -->
    <div id="addModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="addForm" enctype="multipart/form-data" method="post">
                <label for="seller_id">Seller ID:</label><br>
                <input type="text" id="seller_id" name="seller_id" required><br>
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" required><br>
                <label for="fullName">Full Name:</label><br>
                <input type="text" id="fullName" name="fullName" required><br>
                <label for="phoneNumber">Phone Number:</label><br>
                <input type="text" id="phoneNumber" name="phoneNumber" required><br>
                <label for="address">Address:</label><br>
                <input type="text" id="address" name="address" required><br>
                <label for="salary">Salary:</label><br>
                <input type="text" id="salary" name="salary" required><br>
                <label for="photo">Photo:</label><br>
                <input type="file" id="photo" name="photo" required><br>
                <button type="submit" id="submitBtn">Submit</button>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="deleteForm" method="post">
                <label for="delete_username">Username:</label><br>
                <input type="text" id="delete_username" name="delete_username" required><br>
                <button type="submit" name="delete_seller">Delete Seller</button>
            </form>
        </div>
    </div>

    <script>
        // Get the modals
        var addModal = document.getElementById("addModal");
        var deleteModal = document.getElementById("deleteModal");

        // Get the buttons that open the modals
        var addBtn = document.getElementById("addBtn");
        var deleteBtn = document.getElementById("deleteBtn");

        // Get the <span> elements that close the modals
        var closeSpan = document.getElementsByClassName("close");

        // When the user clicks the buttons, open the corresponding modal
        addBtn.onclick = function() {
            addModal.style.display = "block";
        }

        deleteBtn.onclick = function() {
            deleteModal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modals
        for (var i = 0; i < closeSpan.length; i++) {
            closeSpan[i].onclick = function() {
                addModal.style.display = "none";
                deleteModal.style.display = "none";
            }
        }

        // When the user clicks anywhere outside of the modals, close them
        window.onclick = function(event) {
            if (event.target == addModal || event.target == deleteModal) {
                addModal.style.display = "none";
                deleteModal.style.display = "none";
            }
        }
    </script>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include database connection
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

        // Add Seller
        if (isset($_POST['seller_id'])) {
            $stmt = $conn->prepare("INSERT INTO seller (seller_id, username, password, email, full_name, phone_number, address, salary, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $seller_id, $username, $password, $email, $full_name, $phone_number, $address, $salary, $photo);

            // Set parameters and execute
            $seller_id = $_POST['seller_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $full_name = $_POST['fullName'];
            $phone_number = $_POST['phoneNumber'];
            $address = $_POST['address'];
            $salary = $_POST['salary'];
            $photo = file_get_contents($_FILES['photo']['tmp_name']);

            if ($stmt->execute() === TRUE) {
                echo "<script>alert('New seller added successfully');</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
            }

            $stmt->close();
        }

        // Delete Seller
        if (isset($_POST['delete_username'])) {
            $stmt = $conn->prepare("DELETE FROM seller WHERE username = ?");
            $stmt->bind_param("s", $username);

            // Set parameter and execute
            $username = $_POST['delete_username'];

            if ($stmt->execute() === TRUE) {
                echo "<script>alert('Seller deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting seller: " . $conn->error . "');</script>";
            }

            $stmt->close();
        }

        $conn->close();
    }
    ?>
</body>
</html>
