<?php
include 'session_check.php';
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "collab_main";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch data from order_details table
function fetchChartData($conn) {
    $sql = "SELECT product_id, SUM(total) AS total FROM order_details GROUP BY product_id";
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[$row['product_id']] = $row['total'];
        }
    }
    return $data;
}

// Function to update seller's salary
function updateSalary($conn, $sellerUsername, $newSalary) {
    $sql = "UPDATE seller SET salary = $newSalary WHERE username = '$sellerUsername'";
    if ($conn->query($sql) === TRUE) {
        echo "Salary updated successfully";
    } else {
        echo "Error updating salary: " . $conn->error;
    }
}

// Handling form submission to update salary
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["new_salary"])) {
    $sellerUsername = $_POST["username"];
    $newSalary = $_POST["new_salary"];
    updateSalary($conn, $sellerUsername, $newSalary);
}

// Fetching data for chart
$chartData = fetchChartData($conn);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel = "stylesheet " href="./finance.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class = "main-container">
        <div class = "left">
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
                <li> <a href = "analytics.php">Analytics</a></li>
                    <li> <a href = "seller.php">Seller</a></li>
                    <li> <a href = "product.php">Product</a></li>
                    <li> <a href = "finance.php">Finance</a></li>
                    <li> <a href = "message.php">Message</a></li>
                    <li> <a href = "logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class = "right">
            <canvas id="salesChart" width="400" height="300"></canvas>
            <script>
                // Data for chart
                var chartData = <?php echo json_encode($chartData); ?>;
                var productIds = Object.keys(chartData);
                var totals = Object.values(chartData);

                // Create a bar chart
                var ctx = document.getElementById('salesChart').getContext('2d');
                var salesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: productIds,
                        datasets: [{
                            label: 'Total Sales',
                            data: totals,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>

            <!-- Form to update seller's salary -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- <label for="username">Seller Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="new_salary">Salary:</label>
                <input type="number" name="new_salary" id="new_salary" required>
                <button type="submit">Update Salary</button>
            </form>
            <form> -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Seller Username</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Salary</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>