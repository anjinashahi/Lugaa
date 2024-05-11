<?php
// require 'connection.php';

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

if(isset($_POST["submit"])){
    $product_id = $_POST["product_id"];
    $product_name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $color = $_POST["color"];
    $m = $_POST["m"];
    $l = $_POST["l"];
    $xl = $_POST["xl"];

    if($_FILES["image"]["error"] === 4){
        echo "<script>alert('Image does not exist');</script>";
    }
    else{
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

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

            move_uploaded_file($tmpName, 'img/' . $newImageName);
            $query = "INSERT INTO product (product_id, product_name, description, price, quantity, color, m, l, xl, image) VALUES ('$product_id', '$product_name', '$description', '$price', '$quantity', '$color', '$m', '$l', '$xl', '$newImageName')";
            mysqli_query($conn, $query);

            echo "<script>alert('Successfully Added'); </script>";
        }
    }
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel = "stylesheet " href="./product.css">
    <!-- <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
    </style> -->
</head>
<body>
    <div class= "main-container">
    <div class="left">
    <nav>
        <ul class="">
        <ul class="">
                <li class="admin-login">
                    <div class="admin-info">
                        <div class="admin-photo">
                        <!-- <img src="admin.webp" alt="Admin Photo"> -->
                        </div>
                        <div class="admin-name">Hello, Admin</div>
                    </div>
                </li>
                <li> <a href = "admin">Analytics</a></li>
                    <li> <a href = "seller.php">Seller</a></li>
                    <li> <a href = "product.php">Product</a></li>
                    <li> <a href = "finance.php">Finance</a></li>
        </ul>
    </nav>
    </div>
    <div class = "right">
        <form
            class = ""
            action=""
            method = "post"
            autocomplete="off"
            enctype = "multipart/form-data">
        
        <!-- <div class="mb-3">
            <label for="exampleInputName" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="exampleInputName" aria-describedby="nameHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputProductkey" class="form-label">Product id:</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputActual" class="form-label">Actual Price</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputDiscounted" class="form-label">Discounted Price:</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input class="form-control" type="file" id="formFile">
        </div>
        <button type = "submit" class = "btn btn-primary" name = "submit">Submit</button> 
        <br>
        </form>
        <br>
        <a href="productpageLuga.php">Data</a> -->

        <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product name :</label>
                <input type="text" name="name" id="name" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Product id :</label>
                <input type="text" name="product_id" id="product_id" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price :</label>
                <input type="text" name="price" id="price" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <input type="text" name="description" id="description" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity :</label>
                <input type="text" name="quantity" id="quantity" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color :</label>
                <input type="text" name="color" id="color" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="m" class="form-label">M :</label>
                <input type="text" name="m" id="m" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="l" class="form-label">L :</label>
                <input type="text" name="l" id="l" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="xl" class="form-label">XL :</label>
                <input type="text" name="xl" id="xl" class="form-control" required value="">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image :</label>
                <input type="file" name="image" id="image" class="form-control" accept=".jpg, .jpeg, .png" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <br>
        </form>
        <br>
        <a href="productpageLuga.php">Data</a>
    </div>
    </div>
</body>
</html>