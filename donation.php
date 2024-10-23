<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNIPETS | Donation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body style="justify-content: center; align-items: center;">
    <!-- Background -->
    <?php include('background.php'); ?>

        <!-- Header -->
        <div class="header">
            <?php include('header/header.php'); ?>
        </div>

        <hr/>

        <!-- Main Content -->
        <div style="max-width: 800px; margin: 0 auto; text-align: center; padding: 20px; font-family: Arial, sans-serif;">
            
            <!-- Banner Images -->
            <div style="display: flex; justify-content: space-around; margin-bottom: 30px;">
                <img src="img/animalNursery.jpg" alt="Animal Nursery Process" style="width: 45%; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                <img src="img/animalWithFood.jpg" alt="Animal With Food" style="width: 45%; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            </div>
            
            <!-- Donation Message -->
            <h1>Your Donation Makes a Difference!</h1>
            <!-- View Donations Button -->
            <div style="text-align: center; margin-bottom: 30px; margin-top: 20px;">
                <a href="view-donations.php" style="background-color: #ffffff; color: black; padding: 10px 20px; font-size: 18px; border: none; border-radius: 5px; text-decoration: none; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    View Everyone's Donations
                </a>
            </div>
            <p style="margin-bottom: 20px;">Select an amount to donate</p>

            <!-- Donation Options -->
            <form id="donationForm" action="donation-process.php" method="POST">
                <!-- Input Field -->
                <input type="text" value="<?php if (isset($_SESSION['userName'])) {$userName = $_SESSION['userName']; echo $userName;}?>" name="donorName" id="donorName" class="custom-input" placeholder="Donor name" style="margin-bottom: 30px;" required>
                , donation RM <input type="text" name="donationAmount" class="custom-input" id="donationAmount" placeholder="Enter donation amount!" style="margin-bottom: 30px;" required>
            
                <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 30px;">
                    <button type="button" class="donation-btn" onclick="setAmount(30)">RM 30</button>
                    <button type="button" class="donation-btn" onclick="setAmount(50)">RM 50</button>
                    <button type="button" class="donation-btn" onclick="setAmount(100)">RM 100</button>
                    <button type="button" class="donation-btn" onclick="setAmount(150)">RM 150</button>
                    <button type="button" class="donation-btn" onclick="setAmount(250)">RM 250</button>
                    <button type="button" class="donation-btn" onclick="setAmount(500)">RM 500</button>
                    <button type="button" class="donation-btn" onclick="setAmount(5000)">RM 5000</button>
                </div>

                <!-- Payment method -->
                <div class="payment-container">
                    <h2 class="heading">Donate and Support</h2>
                    <p class="sub-heading">Choose your preferred payment method to proceed with your donation.</p>
                    <div class="payment-options">
                        <div class="payment-method">
                            <input type="radio" id="touchAndGo" name="paymentMethod" value="Touch n Go" required>
                            <label for="touchAndGo" class="payment-label">
                                <img src="img/payment/tng.jpg" alt="Touch n Go" class="payment-icon">
                                <strong>Touch 'n Go</strong>
                            </label>
                        </div>
                        <div class="payment-method">
                            <input type="radio" id="creditCard" name="paymentMethod" value="Credit Card" required>
                            <label for="creditCard" class="payment-label">
                                <img src="img/payment/mastercard.png" alt="CreditCard" class="payment-icon">
                                <strong>Credit Card</strong>
                            </label>
                        </div>
                        <div class="payment-method">
                            <input type="radio" id="debitCard" name="paymentMethod" value="Debit Card" required>
                            <label for="debitCard" class="payment-label">
                                <img src="img/payment/visa.png" alt="Debit Card" class="payment-icon">
                                <strong>Debit Card</strong>
                            </label>
                        </div>
                    </div>
                    <br/>
                    <button type="submit" style="background-color: #2a52be; color: white; padding: 15px 30px; font-size: 18px; border: none; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>

        <script>
            function setAmount(amount) {
                document.getElementById('donationAmount').value = amount;
                console.log('Selected amount: RM ' + amount);
            }
            document.getElementById("donationForm").addEventListener("submit", function(event) {
                const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');
                if (!selectedPayment) {
                    event.preventDefault();
                    alert("Please select a payment method to continue.");
                }
            });
        </script>

        <br/><br/>

        <?php include('header/footer.php'); ?>

    </body>
</html>
