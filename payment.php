<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>E ★ BOOKER &bull; Payment</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body style="justify-content: center; align-items: center;">
        <!-- Header -->
        <div class="header">
            <div>
                <a href="index.php"><img class="header-logo" src="img/E-Booker.jpg" alt="main_logo" width="235"/></a>
            </div>
        </div>
        <div class="spacer"></div>
        
        <!-- main -->
        <div style=" display: flex; justify-content: center; align-items: center;">
            <div class="cart-frame">
                <div>
                    <h1 style="text-align: center; margin: 5px;">
                        Payment
                    </h1>
                </div>
                <ol class="cart">
                    <li><span class="no-cart">Cart</span></li>
                    <li><span class="cart">Confirm Payment</span></li>
                    <li><span class="no-cart">Complete!</span></li>
                </ol>
        
                <div>
                    <?php
                        if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        }

                        echo "<form action='http://localhost/e_booker/api/product/to_library.php' method='POST'>
                            <input type='hidden' value='$user_id' name='user_id'>";
                        ?>
                        <header><img src="img/E-Booker.jpg" alt="main_logo" width="100"/></header>
                        <section class="checkout-list-section">
                                <div class="product-list">Total amount Payable</div>
                                <div class="product-list"><?php $price = $_SESSION['price']; echo"RM $price"?></div>
                            </section>
                        <div class="btn-cart-box">
                                 <button class="btn-pay" type='submit'>~Purchase~</button>
                        </div>
                    </form>
                    <a href="cart.php">Back</a>
                </div>
            </div>
        </div>
        
        <footer class="footer">
            © E BOOKER
        </footer>
                
        
    </body>
</html>
