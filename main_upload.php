<?php
require 'connection.php';
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $description = $_POST["description"];
    $sizeX = $_POST["x"];
    $sizeXL = $_POST["xl"];
    $sizeXXL = $_POST["xxl"];
    if($_FILES["image"]["error"] === 4){
        echo
        "<script>'Alert ('Image Does not Exist')'; </script>";

    }
    else{
        $fileName = $_FILES["image"]["name"];
        $fileDescrption = $_FILES["image"]["description"];
        $fileSizeX = $_FILES["image"]["x"];
        $fileSizeXL =  $_FILES["image"]["xl"];
        $fileSizeXXL = $_FILES["image"]["xxl"];
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

            move_uploaded_file($tmpName, 'img/'. $newImageName);
            $query = "INSERT INTO test2 VALUES('', '$name', '$description', '$newImageName', '$sizeX', '$sizeXL', '$sizeXXL')";
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
    <label for = "image"> Image : </label>
    <input type="file" name = "image" id = "image" accept=".jpg, .jpeg, .png" value=""> <br>
    <label for="description"> Description :</label>
    <input type="text" name ="description" id = "description" required value = ""> 
    <br>
    <label for="x">X</label>
    <input type="text" name="x" id="x" required value = "">
    <br>
    <label for="xl">XL</label>
    <input type="text" name="xl" id="xl" required value = "">
    <br>
    <label for="xxl">XXL</label>
    <input type="text" name="xxl" id="xxl" required value = "">
    <br>
    <button type = "submit" name = "submit">submit</button> 
    <br>
    </form>
    <br>
    <!-- <a href="data.php">Data</a> -->
</body>
</html>