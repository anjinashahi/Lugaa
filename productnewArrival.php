<?php 
require 'connection.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page Luga</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
   <section class="container">
   <?php 
   $result = mysqli_query($conn, "SELECT * FROM test5_newarrival ORDER BY id DESC");
   while ($row = mysqli_fetch_assoc($result)) :
   ?>
    
        <div class="card">
        <div id = "productimg"><img src="img/<?php echo $row['image']; ?>" alt=""></div>
        <div id = "name"><?php echo $row["name"]; ?></div>
        <div id = "actual_price"><?php echo $row["act_price"]; ?></div>
        <div id = "discounted_price"><?php echo $row["discounted_price"]; ?></div>
        
        </div>
        
    
    <?php endwhile; ?>
    </section>
</body>
</html>
