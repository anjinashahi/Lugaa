<?php
include 'session_check.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collab_main";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delivered_order_id'])) {
    $delivered_order_id = $_POST['delivered_order_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE order_details SET order_completed = 1, order_pending = 0 WHERE order_id = ?");
    $stmt->bind_param("i", $delivered_order_id);
    
    if ($stmt->execute() === TRUE) {
        echo "Order marked as delivered successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$sqlProduct = "SELECT product_id, product_name, quantity FROM product"; 
$productResult = $conn->query($sqlProduct);

$productData = array();

if ($productResult) {
    while($row = $productResult->fetch_assoc()) {
        $productData[$row['product_id']] = array('product_name' => $row['product_name'], 'quantity' => $row['quantity']);
    }
} else {
    echo "Error: " . $conn->error;
}

// Fetch pending orders where order_pending = 1 and order_completed = 0
$sqlOrder = "SELECT order_id, customer_id, size, phone, product_id, note FROM order_details WHERE order_completed = 0";
$orderResult = $conn->query($sqlOrder);

$orderData = array();

if ($orderResult) {
    if ($orderResult->num_rows > 0) {
        while($row = $orderResult->fetch_assoc()) {
            $orderData[] = $row;
        }
    } else {
        echo "No pending orders found.";
    }
} else {
    echo "Error executing query: " . $conn->error;
}

// Fetch completed orders where order_completed = 1
$sqlCompletedOrders = "SELECT order_id, customer_id, size, phone, product_id FROM order_details WHERE order_completed = 1";
$completedOrdersResult = $conn->query($sqlCompletedOrders);

$completedOrdersData = array();

if ($completedOrdersResult) {
    if ($completedOrdersResult->num_rows > 0) {
        while($row = $completedOrdersResult->fetch_assoc()) {
            $completedOrdersData[] = $row;
        }
    } else {
        echo "No completed orders found.";
    }
} else {
    echo "Error executing query: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        html {
            height: 100%;
        }
        body {
            height: 100%;
        }
        ol, ul {
            padding: 0px;
        }
        .main-container {
            display: flex;
            width: 100%;
            height: 100%;
            min-height: 100vh;
            background-color: white;
            overflow: hidden;
        }
        .left {
            display: flex;
            flex-direction: column;
            width: 20%;
            height: 100%;
            min-height: 100vh;
            background-color: #0056b3;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .left nav ul li {
            margin: 40% 0;
            list-style-type: none;
            border-bottom: #EEE3CB 2px solid;
            border-top: #EEE3CB 2px solid;
            padding: 10px 20px;
        }
        .left nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 18px;
            position: relative;
        }
        .admin-name {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 18px;
            position: relative;
        }
        .left nav ul li a::after {
            content: "";
            width: 0;
            height: 3px;
            background: white;
            position: absolute;
            left: 0;
            bottom: -6px;
            transition: 0.5s;
        }
        .right {
            display: flex;
            flex-direction: column !important;
            height: 100%;
            overflow: hidden;
            position: relative;
            padding: 20px;
        }
        #productChartmain-container {
            width: 400px;
            height: 300px;
            margin: 20px;
        }
        #pendingOrdersmain-container, #completedOrdersmain-container {
            margin-top: 10px;
            max-height: 300px;
            overflow-y: auto;
        }
        table, th, td {
            margin: 10px;
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        .delivered {
            background-color: lightgreen;
        }
        h1 {
            font-size: 30px;
        }
        #productChart {
            margin: 10px;
        }
        .table {
            margin: 15px;
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
                        <li> <a href="analytics.php">Analytics</a></li>
                        <li> <a href="seller.php">Seller</a></li>
                        <li> <a href="product.php">Product</a></li>
                        <li> <a href="finance.php">Finance</a></li>
                        <li> <a href="message.php">Message</a></li>
                        <li> <a href="logout.php">Logout</a></li>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="right">
            <div id="productChartmain-container">
                <h1>Product Quantity</h1>
                <canvas id="productChart"></canvas>
            </div>

            <div id="pendingOrdersmain-container">
                <h1>Pending Orders</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Size</th>
                            <th>Phone</th>
                            <th>Product</th>
                            <th>Action</th>
                            <th>Notes</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($orderData) > 0): ?>
                            <?php foreach($orderData as $order): ?>
                                <tr>
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['customer_id']; ?></td>
                                    <td><?php echo $order['size']; ?></td>
                                    <td><?php echo $order['phone']; ?></td>
                                    <td><?php if(isset($productData[$order['product_id']]['product_name'])){
                                        echo $productData[$order['product_id']]['product_name'];
                                    } else {
                                        echo "Hoodie";
                                    
                                    }; ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="delivered_order_id" value="<?php echo $order['order_id']; ?>">
                                            <button type="submit" class="btn btn-success">Delivered</button>
                                        </form>
                                    </td>
                                    
                                    <td><?php echo $order['note']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No pending orders found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="completedOrdersmain-container">
                <h1>Completed Orders</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Size</th>
                            <th>Phone</th>
                            <th>Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($completedOrdersData as $order): ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['customer_id']; ?></td>
                                <td><?php echo $order['size']; ?></td>
                                <td><?php echo $order['phone']; ?></td>
                                <td><?php if(isset($productData[$order['product_id']]['product_name'])){
                                        echo $productData[$order['product_id']]['product_name'];
                                    } else {
                                        echo "Hoodie";
                                    
                                    }; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('productChart').getContext('2d');
            var productData = <?php echo json_encode(array_values($productData)); ?>;
            var productNames = productData.map(function (product) {
                return product.product_name;
            });
            var productQuantities = productData.map(function (product) {
                return product.quantity;
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: 'Quantity',
                        data: productQuantities,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
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
        });
    </script>
</body>
</html>
