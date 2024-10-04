<?php
include('config/constants.php');

$id = $_GET['id'];

$sql = "SELECT * FROM donation WHERE donationId= '$id'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count>0)
{
    while($row=mysqli_fetch_assoc($res))
    {
        $donorName = $row['donorName'];
        $donationDate = $row['donationDate'];
        $donationAmount = $row['donationAmount'];
        $paymentMethod = $row['paymentMethod'];
    }
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
    <h1>Donation Receipt</h1>

    <div class="receipt-details">
        <p style="color:black;"><strong>Name:</strong> <?php echo $donorName; ?></p>
        <p style="color:black;"><strong>Donation ID:</strong> <?php echo $id; ?></p>
        <p style="color:black;"><strong>Donation Amount:</strong> RM<?php echo number_format($donationAmount, 2); ?></p>
        <p style="color:black;"><strong>Date:</strong> <?php echo $donationDate; ?></p>
        <p style="color:black;"><strong>Payment Method:</strong> <?php echo $paymentMethod; ?></p>
    </div>

    <div class="receipt-footer">
        Thank you for your generous donation!
    </div>

    <!-- Download Receipt Button -->
    <a href="download-receipt.php?donation_id=<?php echo $id; ?>" style="color:white;" class="download-button">Download Receipt</a>
</div>

</body>
</html>
