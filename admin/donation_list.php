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

// Retrieve donation data
$sql = "SELECT donationId, donorName, donationDate, donationAmount, paymentMethod FROM donation";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation List</title>
    <link rel="stylesheet" href="css/adminStyle.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="main-content">
            <h2>Donation List</h2>
            <table style="width: 100%; text-align: center;">
                <thead>
                    <tr>
                        <th>Donation ID</th>
                        <th>Donor Name</th>
                        <th>Donation Date</th>
                        <th>Donation Amount (RM)</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['donationId'] . "</td>";
                            echo "<td>" . $row['donorName'] . "</td>";
                            echo "<td>" . $row['donationDate'] . "</td>";
                            echo "<td>" . number_format($row['donationAmount'], 0) . "</td>";
                            echo "<td>" . $row['paymentMethod'] . "</td>";
                            echo "<td>";
                            // Download receipt link
                            echo "<a style='color: blue;' href='../download-donation-receipt.php?donation_id=" . $row['donationId'] . "' target='_blank'>Download Receipt</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No donations found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
