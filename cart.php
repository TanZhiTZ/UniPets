<?php include('config/constants.php');
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
} else {
    header("location: index.php");
}

$sql = "SELECT * FROM cartitem WHERE userId='$userId'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if ($count == 0) {
    header("location: products.php");
}

?>
<!DOCTYPE html>
<html>
<head>
        <title>UNIPETS | Pets Details</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
    <body>
        <!-- Header -->
        <div class="header">
                <?php include('header/header.php'); ?>
        </div>
        
        <div class="cart-container">
            <!-- Cart Header -->
            <div class="cart-header">
                <img src="img/shopping-bag.png" alt="Cart Icon">
                <span>Cart</span>
            </div>

            <?php
            if($count>0)
            {
                $i = '0';
                while($row=mysqli_fetch_assoc($res))
                {
                    ini_set('display_errors', 0);
                    $accessoriesId = $row['accessoriesId'];
                    $quantity = $row['quantity'];

                    $sql = "SELECT * FROM accessories WHERE accessoriesId='$accessoriesId'";
                    $res2 = mysqli_query($conn, $sql);

                    $accessories = mysqli_fetch_assoc($res2);

                    $productImg = $accessories['productImg'];
                    $productName = $accessories['productName'];
                    $price = $accessories['price'];
                    $stockQuantity = $accessories['stockQuantity'];

                    echo "
                    <!-- Cart Item -->
                    <div class='cart-item'>
                        <a href='product-description.php?product_id=$accessoriesId'><img src='img/products/$productImg' alt='Item Image'></a>
                        <div class='cart-item-details'>
                            <span class='title'>$productName</span>
                            <div class='price' style='font-weight: 900;'>RM$price MYR</div>
                        </div>
                        <div class='quantity-input cart-controls'>
                            <button class='quantity-btn' onclick='decrement($i, $accessoriesId, $price)'>-</button>
                            <input class='quantity-content' type='text' id='quantity$i' value='$quantity' readonly>
                            <button class='quantity-btn' onclick='increment($i, $accessoriesId, $price, $stockQuantity)'>+</button>
                        </div>
                        <div class='wrap'>
                            <span><button class='remove' onclick='deleteData($accessoriesId)'>Delete</button></span>
                        </div>
                    </div>";

                    $tprice = $price * $quantity;
                    $total += $tprice;
                    $i++;
                }
            }
            ?>

            <form id="checkoutForm" style="text-align: center; margin: 20px 0;" action="payment-process.php" method="POST">
            
            <!-- Subtotal -->
            <div class="subtotal" id="totalPrice">
                Total: RM<input name="paymentAmount" value="<?php echo number_format((float)$total, 2, '.', ''); ?>" id="total" style="border:none; width: 100px;" readonly> MYR
                <small>Free Shipping</small>
            </div>

            <!-- Address input -->
            <div class="address-container">
                <h2 class="heading">Shipping Address</h2>
                <div class="form-group">
                    <input type="text" id="addressLine1" name="addressLine1" class="form-control" placeholder="Address Line 1" required>
                </div>
                <div class="form-group">
                    <input type="text" id="addressLine2" name="addressLine2" class="form-control" placeholder="Address Line 2 (Optional)">
                </div>
                <div class="form-group">
                    <input type="text" id="city" name="city" class="form-control" placeholder="City" required>
                </div>
                <div class="form-group">
                    <input type="text" id="state" name="state" class="form-control" placeholder="State/Region" required>
                </div>
                <div class="form-group">
                    <input type="text" id="postalCode" name="postalCode" class="form-control" placeholder="Postal Code" required>
                </div>
            </div>

            <!-- Payment method -->
            <div class="payment-container">
                <h2 class="heading">Payment Method</h2>
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
                            <img src="img/payment/mastercard.png" alt="Credit Card" class="payment-icon">
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
                <br/><br/>
                <button type="submit" style="background-color: #2a52be; color: white; padding: 15px 30px; font-size: 18px; border: none; border-radius: 5px;">
                    Proceed to Payment
                </button>
            </div>
            <br/>
            </form>
        </div>
        
        <br/><br/>
        <?php include('header/footer.php'); ?>

<script>
    document.getElementById("checkoutForm").addEventListener("submit", function(event) {
        const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');
        const addressLine1 = document.getElementById("addressLine1").value.trim();
        const city = document.getElementById("city").value.trim();
        const state = document.getElementById("state").value.trim();
        const postalCode = document.getElementById("postalCode").value.trim();

        if (!selectedPayment) {
            event.preventDefault();
            alert("Please select a payment method to continue.");
        }

        if (!addressLine1 || !city || !state || !postalCode) {
            event.preventDefault();
            alert("Please fill in all required address fields.");
        }
    });

    function deleteData(accessoriesId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "deleteCartItem.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                if (response === "SUCCESS") {
                    location.reload();
                } else {
                    alert("Error removing from cart. Please try again later.");
                }
            }
        };
        xhr.send("accessoriesId=" + accessoriesId);
        location.reload();
    }

    function increment(number, accessoriesId, price, stockQuantity) {
        let quantity = document.getElementById("quantity"+number);
        let currentQuantity = parseInt(quantity.value);
        if (currentQuantity < stockQuantity) {
            quantity.value = currentQuantity + 1;
            let totalPrice = document.getElementById("total");
            total = parseFloat(totalPrice.value) + price;
            totalPrice.value = total.toFixed(2);
        }

        updateCart(accessoriesId, quantity.value);
    }

    function decrement(number, accessoriesId, price) {
        let quantity = document.getElementById("quantity"+number);
        let currentQuantity = parseInt(quantity.value);
        if (currentQuantity > 1) {
            quantity.value = currentQuantity - 1;
            let totalPrice = document.getElementById("total");
            total = parseFloat(totalPrice.value) - price;
            totalPrice.value = total.toFixed(2);
        }

        updateCart(accessoriesId, quantity.value);
    }

    function updateCart(accessoriesId, quantity) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "updateCart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                if (response === "SUCCESS") {
                    console.log("Cart updated");
                } else {
                    console.error("Error updating cart. Please try again later.");
                }
            }
        };
        xhr.send("accessoriesId=" + accessoriesId + "&quantity=" + quantity);
    }
</script>
    </body>
</html>
