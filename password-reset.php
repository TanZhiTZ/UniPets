<?php include('config/constants.php'); ?>
<?php

include 'config/config.php';
ini_set('display_errors', 0);

if(isset($_POST['submit'])){
    if (!isset($_SESSION['rand'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');

        if(mysqli_num_rows($select) > 0){
                // if ($rand == $_SESSION['rand'])
                // session_destroy();
                $rand = rand(100000, 999999);
                $row = mysqli_fetch_assoc($select);
                $_SESSION['email'] = $row['email'];
                $_SESSION['rand'] = $rand;
        }else{
                $message[] = 'Email not found!';
        }
    }
    $rand = $_SESSION['rand'];
}

?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>E ★ BOOKER &bull; Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body style="background-image:url('img/bg-login.jpg'); display: flex; justify-content: center; align-items: center;">
    <div class="frame" align="middle">
            <h2>Forgot Password</h2><br/>
            <form action="" method="POST" enctype="multipart/form-data">
            <?php
                if (!isset($rand)){
                    echo "<p>Enter your Email:
                    <div class='field'>
                        <input type='email' class='textbox' name='email' placeholder='Email' required='required'>
                    </div>";
                }else {
                    echo "<p>Enter your Verification Code:
                    <div class='field'>
                        <input type='verify' class='textbox' name='verify' placeholder='Verification code' required='required'>
                    </div>";
                }
                
            
                if(isset($message)){
                    foreach($message as $message){
                    echo '<div class="message" style="color:red; font-size:12px;">'.$message.'</div><br/>';
                    }
                }
                
                if (isset($rand)) {
                echo "$rand";
                echo "<div class='field'>
                            <button class='buttondeco' name='submit' type='submit'><b>Enter</b></button>
                    </div>";
                }else {
                echo "<div class='field'>
                            <button class='buttondeco' name='submit' type='submit'><b>Send Verification Code</b></button>
                    </div>";
                }

                
                
                if (isset($_SESSION['email'])&&isset($_POST['submit'])&&isset($_POST['verify'])) {
                    $verify = mysqli_real_escape_string($conn, $_POST['verify']);
                    if ($verify==$rand){
                        $verified = true;
                        $_SESSION['rand'] = null;
                        $_SESSION['verified'] = $verified;
                        header('location:password-reset_verified.php');
                    }
               }
            ?>
            </form>
                
        <script src="js/main.js"></script>
    </body>
</html>
