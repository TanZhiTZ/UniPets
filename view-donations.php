<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNIPETS | Donor List</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/background.css">
    </head>
    <body>
        <!-- Header -->
        <div class="header">
                <?php include('header/header.php'); ?>
        </div>

        <div class="container history-frame" style="display: flex; flex-direction: column; text-align: center;">
            <h1 style="padding-bottom: 20px;">All Donations</h1>
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Donation ID</th>
                        <th>Donor Name</th>
                        <th>Date</th>
                        <th>Amount (RM)</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve all donations from the 'donation' table
                    $sql = "SELECT donationId, donorName, donationDate, donationAmount, paymentMethod FROM donation";
                    $res = mysqli_query($conn, $sql);

                    // Check if there are any donations
                    if (mysqli_num_rows($res) > 0) {
                        // Loop through each donation and display it in the table
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>";
                            echo "<td><a href='donation-receipt.php?donationId=". $row['donationId'] . "'>" . $row['donationId'] . "</a></td>";
                            echo "<td>" . $row['donorName'] . "</td>";
                            echo "<td>" . date('d M Y', strtotime($row['donationDate'])) . "</td>";
                            echo "<td>" . number_format($row['donationAmount'], 2) . "</td>";
                            echo "<td>" . $row['paymentMethod'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No donations found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <?php include('header/footer.php'); ?>
    </body>
</html>
