<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
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

// Check if form is submitted for delivering an order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delivered_order_id'])) {
    $delivered_order_id = $_POST['delivered_order_id'];

    // Update order status to "Delivered" in the database
    $sqlUpdate = "UPDATE order_details SET order_completed = 1 WHERE order_id = $delivered_order_id";

    if ($conn->query($sqlUpdate) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }
}

// SQL query to fetch product names and quantities
$sqlProduct = "SELECT product_name, quantity FROM product"; 

$productResult = $conn->query($sqlProduct);

$productData = array();

// Process product query result
if ($productResult) {
    while($row = $productResult->fetch_assoc()) {
        $productData[$row['product_name']] = $row['quantity'];
    }
} else {
    echo "Error: " . $conn->error;
}

// SQL query to fetch order details
$sqlOrder = "SELECT order_id, customer_id, address, phone, order_completed FROM order_details";

$orderResult = $conn->query($sqlOrder);

$orderData = array();

// Process order query result
if ($orderResult) {
    if ($orderResult->num_rows > 0) {
        while($row = $orderResult->fetch_assoc()) {
            $orderData[] = $row;
        }
    } else {
        echo "No orders found.";
    }
} else {
    echo "Error executing query: " . $conn->error;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel = "stylesheet " href="./analytics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <style>
        /* CSS for the first div */
        #productChartmain-container {
            width: 400px; /* Adjust the width as needed */
            height: 300px; /* Adjust the height as needed */
        }
        
        /* CSS for the second div */
        #pendingOrdersmain-container {
            margin-top: 70px; /* Adjust the margin-top as needed */
        }
        
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        /* CSS for the delivered orders */
        .delivered {
            background-color: lightgreen;
        }
    </style> -->
</head>
<body>
    <div class = "main-container">
        <div class= "left">
            <nav>
                <ul class="">
                <li class="admin-login">
                    <div class="admin-info">
                        <div class="admin-photo">
                        <!-- <img src="admin.webp" alt="Admin Photo"> -->
                        </div>
                        <div class="admin-name">Hello, Admin</div>
                    </div>
                    <li> <a href = "admin">Analytics</a></li>
                    <li> <a href = "seller.php">Seller</a></li>
                    <li> <a href = "product.php">Product</a></li>
                    <li> <a href = "finance.php">Finance</a></li>
                </ul>
            </nav>
        </div>
        <div class="right">
            <div id="productChartmain-container">
                <h1>Product Quantity Chart</h1>
                <canvas id="productChart" width="400" height="300"></canvas>
                <script>
                    var productData = <?php echo json_encode($productData); ?>;
                    var productNames = Object.keys(productData);
                    var productQuantities = Object.values(productData);
                    
                    var ctx = document.getElementById('productChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productNames,
                            datasets: [{
                                label: 'Analytics',
                                data: productQuantities,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>

        <!-- Pending Orders -->
        <div id="pendingOrdersmain-container">
            <h1>Pending Orders</h1>
            <table class="table table-striped">
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                <?php foreach($orderData as $order): ?>
                <tr <?php if (isset($order['order_completed']) && $order['order_completed'] == 1) echo 'class="delivered"'; ?>>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['customer_id']; ?></td>
                    <td><?php echo $order['address']; ?></td>
                    <td><?php echo $order['phone']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="delivered_order_id" value="<?php echo $order['order_id']; ?>">
                            <input type="submit" value="Delivered">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>
</div>
</body>
</html>