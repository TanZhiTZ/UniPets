<?php
include '../config/constants.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    if ($role != "admin") {
        header('location:../index.php');
    }
} else {
    header('location:../index.php');
}

// Retrieve purchase order data
$sql = "SELECT orderId, userId, userName, orderDate, totalAmount, paymentMethod FROM purchaseorder";
$result = $conn->query($sql);

// Function to download the receipt
if (isset($_POST['downloadReceipt'])) {
    $orderId = $_POST['orderId'];
    
    // Implement receipt download logic here, such as generating a PDF or serving an already stored receipt file.
    // For simplicity, we'll assume you have a PDF stored with the name pattern 'receipt_<orderId>.pdf'
    
    $receiptFile = "../receipts/receipt_$orderId.pdf";  // Adjust path if necessary

    if (file_exists($receiptFile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . basename($receiptFile));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($receiptFile));
        readfile($receiptFile);
        exit;
    } else {
        echo "Receipt not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order List</title>
    <link rel="stylesheet" href="css/adminStyle.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="main-content">
            <h2>Purchase Order List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User Name</th>
                        <th>Order Date</th>
                        <th>Total Amount (RM)</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['orderId'] . "</td>";
                            echo "<td>" . $row['userName'] . "</td>";
                            echo "<td>" . $row['orderDate'] . "</td>";
                            echo "<td>" . $row['totalAmount'] . "</td>";
                            echo "<td>" . $row['paymentMethod'] . "</td>";
                            echo "<td>";

                            // Download receipt button
                            echo "<a style='color: blue;' href='../download-payment-receipt.php?orderId=" . $row['orderId'] . "' target='_blank'>Download Receipt</a>";

                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No purchase orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
