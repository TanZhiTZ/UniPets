<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>E ★ BOOKER &bull;  Checkout</title>
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
            <div class="cart-frame"  style="display: flex; flex-direction: column; align-items: center;">
                <img src="img/E-Booker2.jpg" alt="main_logo" width="300"/>
                <div>
                    <h1 style="text-align: center; margin: 5px;">
                        Payment Complete!
                    </h1>
                </div>
                <form action="index.php">
                    <div>
                        <div>
                            <h2 style="color: #107068">Thank you for your purchase!</h2>
                        </div>
                        <hr>
                        <div style="margin-top: 20px;">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                        }

                            echo "<a href='user_library.php?id=$user_id'>To your books collection! ></a>";
                        ?>
                        </div>
                        <div class="btn-cart-box">
                            <button class="btn-cart">Back to Home</button>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
        
        <footer class="footer">
            © E BOOKER
        </footer>
        
    </body>
</html>
