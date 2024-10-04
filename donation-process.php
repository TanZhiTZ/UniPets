<?php
include 'config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donationAmount = $_POST['donationAmount'];
    $donorName = $_POST['donorName'];
    $paymentMethod = $_POST['paymentMethod'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <title>UNIPETS | Payment Method</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/background.scss">
    </head>
    <body>
    
    <div style="max-width: 800px; margin: 0 auto; text-align: center; padding: 20px; font-family: Arial, sans-serif;">
        
        <!-- Payment Options -->
        <form id="paymentForm" action="" method="POST">

        <input name="donorName" id="donorName" value="<?php echo"$donorName"; ?>" class="hidden">
        <input name="donationAmount" id="donationAmount" value="<?php echo"$donationAmount"; ?>" class="hidden">
        <input name="paymentMethod" id="paymentMethod" value="<?php echo"$paymentMethod"; ?>" class="hidden">

            <div class="payment-container">
                <!-- Card Fields (Hidden initially) -->
                <div id="debitCardFields" class="hidden">
                    <h3>Card Information</h3>
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" maxlength="16" placeholder="1234 5678 9012 3456" required>
                    
                    <label for="expiryDate">Expiry Date</label>
                    <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                    
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="123" required>
                    
                    <label for="cardHolder">Cardholder's Name</label>
                    <input type="text" id="cardHolder" name="cardHolder" placeholder="Full Name" required>
                </div>

                <!-- Touch n Go QR Code (Hidden initially) -->
                <div id="touchAndGoQRCode" class="hidden">
                    <h3>Scan QR Code for Touch 'n Go Payment</h3>
                    <img src="img/payment/tng_qrcode.jpg" alt="Touch 'n Go QR Code" class="qrcode">
                </div>

                <button name="submit" type="submit" style="background-color: #2a52be; color: white; padding: 15px 30px; font-size: 18px; border: none; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    Submit Payment
                </button>
                <?php
                    //ini_set('display_errors', 0);
                    if (isset($_POST['submit'])) {
                            $id = rand(1000000, 9999999);

                            $sql = "SELECT * FROM donation WHERE donationId= '$id'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if($count == 0){
                                $query = "INSERT INTO donation (donationId, donorName, donationAmount, paymentMethod) VALUES ('$id', '$donorName', '$donationAmount', '$paymentMethod')";
                                if ($conn->query($query)) {
                                    header('location:receipt.php?id='.$id);
                                } else {
                                    echo 'Error: ' . $conn->error;
                                }
                            }
                    }
                ?>
            </div>
        </form>
    </div>

    <script>
        const selectedPayment = "<?php echo htmlspecialchars($paymentMethod); ?>";
        console.log(selectedPayment);

        if (selectedPayment === 'Debit Card') {
                debitCardFields.classList.remove('hidden');
                touchAndGoQRCode.classList.add('hidden');
            } else if (selectedPayment === 'Credit Card') {
                debitCardFields.classList.remove('hidden');
                touchAndGoQRCode.classList.add('hidden');
            } else if (selectedPayment === 'Touch n Go') {
                touchAndGoQRCode.classList.remove('hidden');
                debitCardFields.classList.add('hidden');
                document.getElementById("cardNumber").required = false;
                document.getElementById("expiryDate").required = false;
                document.getElementById("cvv").required = false;
                document.getElementById("cardHolder").required = false;
            }
    </script>
</body>
</html>
