<?php
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
    <title>Product Sales Chart</title>
    <link rel = "stylesheet " href="./finance.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="salesChart" width="400" height="200"></canvas>
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
        <label for="username">Seller Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="new_salary">Salary:</label>
        <input type="number" name="new_salary" id="new_salary" required>
        <button type="submit">Update Salary</button>
    </form>
</body>
</html>