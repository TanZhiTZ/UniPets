<?php
include('config/constants.php');

$badWordsFilePath = "badwords.txt";

function loadBadWords($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }

    // Read the file and split into an array
    $badWords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    return $badWords;
}

function containsInappropriateWords($string, $bad) {
    foreach ($bad as $word) {
        if (stripos($string, $word) !== false) {
            return true; // Inappropriate word found
        }
    }
    return false;
}

$badWords = loadBadWords($badWordsFilePath);

// Sanitize donor name and check for inappropriate words
$donorName = $_POST['donorName'];

if (containsInappropriateWords($donorName, $badWords)) {
    echo '<script> alert("Please use a valid donor name without inappropriate words!");
    window.location.href = "donation.php"; </script>';
}

$donorName = htmlspecialchars($donorName, ENT_QUOTES, 'UTF-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the donation amount
    $donationAmount = $_POST['donationAmount'];
    if (!is_numeric($donationAmount) || $donationAmount <= 0) {
        echo '<script> alert("Please enter a numeric amount!");
        window.location.href = "donation.php"; </script>';
    } else if ($donationAmount > 10000) {
        echo '<script> alert("Donation amount too big! Please walk-in to donate!");
        window.location.href = "donation.php"; </script>';
    }
    
    // Sanitize payment method
    $paymentMethod = $_POST['paymentMethod'];
}
$paymentMethod = htmlspecialchars($paymentMethod, ENT_QUOTES, 'UTF-8');
$donationAmount = htmlspecialchars($donationAmount, ENT_QUOTES, 'UTF-8');
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
        <link rel="stylesheet" href="css/spinner.css">
    </head>
    <body>
    
    <!-- Loader Spinner -->
    <svg id="loader" class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>
    
    <div class="page-content" style="max-width: 800px; margin: 0 auto; text-align: center; padding: 20px; font-family: Arial, sans-serif;">
        
        <!-- Payment Options -->
        <form id="paymentForm" action="" method="POST">

        <input name="donorName" id="donorName" value="<?php echo $donorName; ?>" class="hidden">
        <input name="donationAmount" id="donationAmount" value="<?php echo $donationAmount; ?>" class="hidden">
        <input name="paymentMethod" id="paymentMethod" value="<?php echo $paymentMethod; ?>" class="hidden">

        <input name="paymentAmount" id="paymentAmount" value="<?php echo htmlspecialchars($paymentAmount, ENT_QUOTES, 'UTF-8'); ?>" class="hidden">

        <div class="payment-container" style="width: 500px;">
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
            if (isset($_POST['submit'])) {
                $donationId = rand(1000000, 9999999);
                
                // Use a prepared statement to prevent SQL injection
                $sql = "SELECT * FROM donation WHERE donationId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $donationId);
                $stmt->execute();
                $res = $stmt->get_result();
                $count = $res->num_rows;

                if ($count == 0) {
                    $query = "INSERT INTO donation (donationId, donorName, donationAmount, paymentMethod) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('isss', $donationId, $donorName, $donationAmount, $paymentMethod);
                    if ($stmt->execute()) {
                        header('location:donation-receipt.php?donationId=' . $donationId);
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
    // Set a timer for the page content to appear after a specified delay
    window.addEventListener('load', function() {
        var delayTime = 3000;

        setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
            document.querySelector('.page-content').style.display = 'block';
        }, delayTime);
    });

    const selectedPayment = "<?php echo htmlspecialchars($paymentMethod); ?>";
    console.log(selectedPayment);

    if (selectedPayment === 'Debit Card' || selectedPayment === 'Credit Card') {
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
