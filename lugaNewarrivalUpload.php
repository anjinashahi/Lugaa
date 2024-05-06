<?php
require 'connection.php';
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    //$product_key = $_POST["product_key"];
    $actual_price = $_POST["act_price"];
    $discounted = $_POST["discounted_price"];
    if($_FILES["image"]["error"] === 4){
        echo
        "<script>'Alert ('Image Does not Exist')'; </script>";

    }
    else{
        $fileName = $_FILES["image"]["name"];
        $fileActualP = $_FILES["image"]["actual_price"];
        $fileDiscountedp = $_FILES["image"]["discounted_price"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg','jpeg','png'];
        $imageExtension = explode('.',$fileName);
        $imageExtension = strtolower(end($imageExtension));
        if(!in_array($imageExtension, $validImageExtension)){
            echo
            "<script>
            alert('Image Does Not Exist');
            </script>";
        }
        else if ($fileSize > 100000000){
            echo
            "<script>
            alert('Image Size is too large')
            </script>";
        }
        else{
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'E:\xampp\htdocs\Lugaa-johnson\img/'. $newImageName);
            $query = "INSERT INTO test5_newarrival (name, image, act_price, discounted_price) VALUES ('$name', '$newImageName', '$actual_price', '$discounted')";
            mysqli_query($conn, $query);

            echo "<script>
            alert('Successfully Added'); document.location.herf = 'data.php' </script>";
        }
    }
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload </title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <form
    class = ""
    action=""
    method = "post"
    autocomplete="off"
    enctype = "multipart/form-data"
    >
    <label for="name">Name :</label>
    <input type="text" name = "name" id = "name" required value = "">
    <br>
    <label for="product_key">Product Key :</label>
    <input type="text" name = "product_key" id = "product_key" required value = "">
    <br>
    <label for="act_price">Actual Price :</label>
    <input type="text" name = "act_price" id = "act_price" required value = "">
    <br>
    <label for="discounted_price">Discounted Price :</label>
    <input type="text" name = "discounted_price" id = "discounted_price" required value = "">
    <br>
    <label for = "image"> Image : </label>
    <input type="file" name = "image" id = "image" accept=".jpg, .jpeg, .png" value=""> <br>
    
    <button type = "submit" name = "submit">submit</button> 
    <br>
    </form>
    <br>
    <a href="productpageLuga.php">Data</a>
</body>
</html>