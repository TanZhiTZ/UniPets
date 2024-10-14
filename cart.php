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
    header("location: index.php");
}

?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>UNIPETS | Pets Details</title>
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
                    $accessoriesId = $row['accessoriesId'];
                    $quantity = $row['quantity'];

                    $sql = "SELECT * FROM accessories WHERE accessoriesId='$accessoriesId'";
                    $res2 = mysqli_query($conn, $sql);

                    $accessories = mysqli_fetch_assoc($res2);

                    $productImg = $accessories['productImg'];
                    $productName = $accessories['productName'];
                    $productDescription = $accessories['productDescription'];
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

            <form style="text-align: center; margin: 20px 0;" action="payment-process.php" method="POST">

            <!-- Subtotal -->
            <div class="subtotal" id="totalPrice">
                Total: RM<input name="paymentAmount" value="<?php echo number_format((float)$total, 2, '.', ''); ?>" id="total" style="border:none; width: 100px;" readonly> MYR
                <small>Free Shipping</small>
            </div>
            <!-- Payment method -->
                <div class="payment-container">
                    <h2 class="heading">Payment Method</h2>
                    <p class="sub-heading">Choose your preferred payment method to proceed with checkout.</p>
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
                        <br/>
                        <button type="submit" style="background-color: #2a52be; color: white; padding: 15px 30px; font-size: 18px; border: none; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                            Proceed to Payment
                        </button>
                </div>
            </form>
        </div>
        
        
        <br/><br/>
        <?php include('header/footer.php'); ?>

<script>
    document.getElementById("paymentMethod").addEventListener("submit", function(event) {
            const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');
            if (!selectedPayment) {
                event.preventDefault();
                alert("Please select a payment method to continue.");
            }
    });

    function deleteData(accessoriesId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "deleteCartItem.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                console.log("Response:", response);
                if (response === "SUCCESS") {
                    console.log("Item removed from cart.");
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
        if (quantity.value < stockQuantity) {
            quantity.value = currentQuantity + 1;
            let totalPrice = document.getElementById("total");
            total = parseFloat(totalPrice.value) + price;
            totalPrice.value = total.toFixed(2);
        }

        console.log("Accessories ID:", accessoriesId);
        console.log("Quantity:", quantity);

        let quantityVal = parseInt(document.getElementById("quantity"+number).value);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "updateCart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                console.log("Response:", response);
                if (response === "NOT_LOGGED_IN") {
                    alert("Please log in to check  your cart.");
                } else if (response === "SUCCESS") {
                    console.log("Cart updated to " + quantityVal + " items.");
                } else {
                    alert("Error adding to cart. Please try again." + response);
                }
            }
        };
        xhr.send("accessoriesId=" + accessoriesId + "&quantity=" + quantityVal);
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


        console.log("Accessories ID:", accessoriesId);
        console.log("Quantity:", quantity);

        let quantityVal = parseInt(document.getElementById("quantity"+number).value);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "updateCart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                console.log("Response:", response);
                if (response === "NOT_LOGGED_IN") {
                    alert("Please log in to check  your cart.");
                } else if (response === "SUCCESS") {
                    console.log("Cart updated to " + quantityVal + " items.");
                } else {
                    alert("Error adding to cart. Please try again." + response);
                }
            }
        };
        xhr.send("accessoriesId=" + accessoriesId + "&quantity=" + quantityVal);
    }
</script>

    </body>
</html>
