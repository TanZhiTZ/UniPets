<?php
include('config/constants.php');

$userId = $_SESSION['userId'];
$userName = $_SESSION['userName'];

$orderId = $_GET['orderId'];

$sql = "SELECT * FROM purchaseorder WHERE orderId= '$orderId'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count>0)
{
    while($row=mysqli_fetch_assoc($res))
    {
        $orderDate = $row['orderDate'];
        $totalAmount = $row['totalAmount'];
        $paymentMethod = $row['paymentMethod'];
    }
} else {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>UNIPETS | Pets List</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" 
       src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <!-- Background -->
    <?php include('background.php'); ?>
    
    <!-- Header -->
    <div class="header">
            <?php include('header/header.php'); ?>
    </div>
    <br/></br>

<div class="receipt-container">
    <h1>Payment Receipt</h1>

    <div class="receipt-details">
        <p style="color:black;"><strong>Name:</strong> <?php echo $userName; ?></p>
        <p style="color:black;"><strong>Payment ID:</strong> <?php echo $orderId; ?></p>
        <p style="color:black;"><strong>Payment Amount:</strong> RM<?php echo number_format($totalAmount, 2); ?></p>
        <p style="color:black;"><strong>Date:</strong> <?php echo $orderDate; ?></p>
        <p style="color:black;"><strong>Payment Method:</strong> <?php echo $paymentMethod; ?></p>
    </div>

    <div class="receipt-footer">
        Thank you for your purchase!
    </div>

    <!-- Download Receipt Button -->
    <a href="download-payment-receipt.php?orderId=<?php echo $orderId; ?>" style="color:white;" class="download-button">Download Receipt</a>
</div>

</body>
</html>
