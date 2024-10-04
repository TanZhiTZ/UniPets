<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>E ★ BOOKER &bull; Cart</title>
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
                        Cart
                    </h1>
                </div>
                <ol class="cart">
                    <li><span class="cart">Cart</span></li>
                    <li><span class="no-cart">Confirm Payment</span></li>
                    <li><span class="no-cart">Complete!</span></li>
                </ol>
                <div class="product-table">
                    <header class="product-list-header">
                        <h3 class="product-title">Product Name & Information</h2>
                        <div class="product-title">delete</div>
                    </header>
                    <section class="product-list-section">
                        <?php 
                            $user_id = $_SESSION['user_id'];
                            $json = file_get_contents("http://localhost/e_booker/api/product/read_cart.php?id=$user_id");
                            $data = json_decode($json);
                            $tprice = 0;

                            foreach ($data->records as $idx => $records) {
                                echo "
                                <div class='product-list'><img src='img/books/$records->book_img_name' class='img-cart product-list-desc product-list'>
                                    <div class='product-list'>Title: $records->book_title</div>
                                    Price: RM $records->book_price
                                    <div>
                                    <form action='http://localhost/e_booker/api/product/delete.php' method='POST'>
                                        <input type='hidden' value='$user_id' name='user_id'>
                                        <input type='hidden' value='$records->book_id' name='book_id'>
                                    
                                    
                                    </div>
                                    </div>
                                <div class='product-list-checkbox'><div style='float: right; margin-top: 90px;'><button type='submit'>delete</button></div></div></form>";
                                $tprice += $records->book_price;
                            }
                            $_SESSION['price'] = $tprice;
                        ?>
                    </section>
                </div>

                <div class="btn-cart-box">
                    <form action="payment.php">
                        <button class="btn-cart">Payment Method ></button>
                    </form>
                </div>
                <a href="index.php">Back</a>
            </div>
        </div>
        <footer class="footer">
            © E BOOKER
        </footer>
    </body>
</html>
