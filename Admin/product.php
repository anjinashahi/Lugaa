<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./product.css">
    <style>
        .form-container {
            display: flex;
            justify-content: space-between;
            margin-top: 70px;
        }
        .form-container > div {
            width: 48%;
        }
        .center-container {
            display: flex;
            justify-content: center;
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
                    </li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li><a href="seller.php">Seller</a></li>
                    <li><a href="product.php">Product</a></li>
                    <li><a href="finance.php">Finance</a></li>
                    <li><a href="message.php">Message</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="right">
            <div class="mb-3">
                <label for="action_dropdown" class="form-label">Select Action:</label>
                <select class="form-control" id="action_dropdown" onchange="toggleForm()">
                    <option value="add_product" selected>Add Product</option>
                    <option value="delete_product">Delete Product</option>
                </select>
            </div>
            <div id="add_product_form">
                <div class="center-container">
                    <div class="form-container">
                        <div id="product_page">
                            <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product id:</label>
                                    <input type="text" name="product_id" id="product_id" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price:</label>
                                    <input type="text" name="price" id="price" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <input type="text" name="description" id="description" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color:</label>
                                    <input type="text" name="color" id="color" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="m" class="form-label">M:</label>
                                    <input type="text" name="m" id="m" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="l" class="form-label">L:</label>
                                    <input type="text" name="l" id="l" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="xl" class="form-label">XL:</label>
                                    <input type="text" name="xl" id="xl" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image:</label>
                                    <input type="file" name="image" id="image" class="form-control" accept=".jpg, .jpeg, .png" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="product_submit">Submit Product</button>
                            </form>
                        </div>
                        <!-- <div id="discount_product">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="product_id_discounted" class="form-label">Product id:</label>
                                    <input type="text" name="product_id" id="product_id_discounted" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="actual_price" class="form-label">Actual Price:</label>
                                    <input type="text" name="actual_price" id="actual_price" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="discounted_price" class="form-label">Discounted Price:</label>
                                    <input type="text" name="discounted_price" id="discounted_price" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <input type="text" name="description" id="description" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color:</label>
                                    <input type="text" name="color" id="color" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="m" class="form-label">M:</label>
                                    <input type="text" name="m" id="m" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="l" class="form-label">L:</label>
                                    <input type="text" name="l" id="l" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="xl" class="form-label">XL:</label>
                                    <input type="text" name="xl" id="xl" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image:</label>
                                    <input type="file" name="image" id="image" class="form-control" accept=".jpg, .jpeg, .png" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="discounted_product_submit">Submit Discounted Product</button>
                            </form>
                        </div> -->
                    </div>
                </div>
            </div>
            <div id="delete_product_form" style="display: none;">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="delete_type" class="form-label">Select Type:</label><br>
                        <input type="radio" id="product_radio" name="delete_type" value="product" checked>
                        <label for="product_radio">Product</label><br>
                        <input type="radio" id="offer_product_radio" name="delete_type" value="offer_product">
                        <label for="offer_product_radio">Offer Product</label><br>
                    </div>
                    <div class="mb-3">
                        <label for="delete_product_id" class="form-label">Product ID:</label>
                        <input type="text" name="delete_product_id" id="delete_product_id" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger" name="delete_submit">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            var actionDropdown = document.getElementById("action_dropdown");
            var addProductForm = document.getElementById("add_product_form");
            var deleteProductForm = document.getElementById("delete_product_form");

            if (actionDropdown.value === "add_product") {
                addProductForm.style.display = "block";
                deleteProductForm.style.display = "none";
            } else if (actionDropdown.value === "delete_product") {
                addProductForm.style.display = "none";
                deleteProductForm.style.display = "block";
            }
        }
    </script>
</body>
</html>

<?php
// include 'session_check.php';

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

if(isset($_POST["product_submit"])){
    // Code to add product to the product table
    $product_id = $_POST["product_id"];
    $product_name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $color = $_POST["color"];
    $m = $_POST["m"];
    $l = $_POST["l"];
    $xl = $_POST["xl"];
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    // Check for image
    if($_FILES["image"]["error"] === 4){
        echo "<script>alert('Image does not exist');</script>";
    }
    else{
        $validImageExtension = ['jpg','jpeg','png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(!in_array($imageExtension, $validImageExtension)){
            echo "<script>alert('Invalid image format');</script>";
        }
        else if ($fileSize > 100000000){
            echo "<script>alert('Image size is too large');</script>";
        }
        else{
            $newImageName = uniqid('', true) . '.' . $imageExtension;
            move_uploaded_file($tmpName, '../img/' . $newImageName);
            $query = "INSERT INTO product (product_id, product_name, description, price, quantity, color, m, l, xl, image) VALUES ('$product_id', '$product_name', '$description', '$price', '$quantity', '$color', '$m', '$l', '$xl', '$newImageName')";
            if(mysqli_query($conn, $query)){
                echo "<script>alert('Successfully Added to Product Table');</script>";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
}

if(isset($_POST["discounted_product_submit"])){
    // Code to add product to the discounted_product table
    $product_id = $_POST["product_id"];
    $actual_price = $_POST["actual_price"];
    $discounted_price = $_POST["discounted_price"];

    $discounted_query = "INSERT INTO discounted_product (product_id, actual_price, discounted_price) VALUES ('$product_id', '$actual_price', '$discounted_price')";
    if(mysqli_query($conn, $discounted_query)){
        echo "<script>alert('Successfully Added to Discounted Product Table');</script>";
    } else {
        echo "Error: " . $discounted_query . "<br>" . mysqli_error($conn);
    }
}

if(isset($_POST["delete_submit"])){
    // Code to delete product from either product or discounted_product table
    $delete_product_id = $_POST["delete_product_id"];
    $delete_type = $_POST["delete_type"];

    if($delete_type == "product"){
        $delete_query = "DELETE FROM product WHERE product_id = '$delete_product_id'";
    }
    else if($delete_type == "offer_product"){
        $delete_query = "DELETE FROM discounted_product WHERE product_id = '$delete_product_id'";
    }

    if(mysqli_query($conn, $delete_query)){
        echo "<script>alert('Successfully Deleted');</script>";
    } else {
        echo "Error: " . $delete_query . "<br>" . mysqli_error($conn);
    }
}
?>
