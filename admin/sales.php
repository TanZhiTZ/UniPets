<?php
include '../config/constants.php';

// Check if the user is an admin
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    if ($role != "admin") {
        header('location:../index.php');
    }
} else {
    header('location:../index.php');
}

// Check if a month is selected by the user, otherwise default to the current month
$selectedMonth = isset($_POST['month']) ? $_POST['month'] : date('m');
$currentYear = date('Y');

// Query to get sales for the selected month
$sql_month = "SELECT SUM(totalAmount) AS monthlyTotal FROM purchaseorder WHERE MONTH(orderDate) = '$selectedMonth' AND YEAR(orderDate) = '$currentYear'";
$res_month = mysqli_query($conn, $sql_month);
$row_month = mysqli_fetch_assoc($res_month);
$monthlyTotal = $row_month['monthlyTotal'] ?? 0; // Total sales for the selected month

// Query to get sales for each month of the current year
$salesData = [];
for ($month = 1; $month <= 12; $month++) {
    $sql_year = "SELECT SUM(totalAmount) AS total FROM purchaseorder WHERE MONTH(orderDate) = '$month' AND YEAR(orderDate) = '$currentYear'";
    $res_year = mysqli_query($conn, $sql_year);
    $row_year = mysqli_fetch_assoc($res_year);
    $salesData[] = $row_year['total'] ?? 0; // Add to the sales data array
}

// Returning month names
function getMonthName($month) {
    return date("F", mktime(0, 0, 0, $month, 10));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Summary</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/adminStyle.css">
    <style>
        .chart-container {
            width: 80%;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
        }
        .form-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">

        <div class="main-content">
            <div class="form-container">
                <form method="POST" action="">
                    <label for="month">Select Month:</label>
                    <select name="month" id="month" onchange="this.form.submit()">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = ($i == $selectedMonth) ? 'selected' : '';
                            echo "<option value='$i' $selected>" . getMonthName($i) . "</option>";
                        }
                        ?>
                    </select>
                </form>
            </div>

            <div class="chart-container">
                <h2>Selected Month's Sales (<?php echo getMonthName($selectedMonth) . " " . $currentYear; ?>)</h2>
                <canvas id="monthlySalesChart"></canvas>
            </div>

            <div class="chart-container">
                <h2>Yearly Sales (<?php echo $currentYear; ?>)</h2>
                <canvas id="yearlySalesChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Selected month's sales chart
        const monthlySalesData = {
            labels: ['<?php echo getMonthName($selectedMonth); ?>'], // selected month
            datasets: [{
                label: 'Sales in RM',
                data: [<?php echo $monthlyTotal; ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Yearly sales chart
        const yearlySalesData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Sales in RM',
                data: <?php echo json_encode($salesData); ?>, // Monthly sales data
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Monthly Sales Chart
        const ctx1 = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx1, {
            type: 'bar',
            data: monthlySalesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Yearly Sales Chart
        const ctx2 = document.getElementById('yearlySalesChart').getContext('2d');
        const yearlySalesChart = new Chart(ctx2, {
            type: 'bar',
            data: yearlySalesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
