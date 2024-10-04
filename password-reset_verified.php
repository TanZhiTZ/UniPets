<?php include('config/constants.php'); ?>
<?php

include 'config/config.php';

if(isset($_POST['submit'])){

   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $email = $_SESSION['email'];

   if($pass != $cpass){
    $message[] = 'Password does not match!';
    }else {

        $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');

        if(mysqli_num_rows($select) > 0){

                $insert = mysqli_query($conn, "UPDATE `user` SET `password`='$pass' WHERE email = '$email'") or die('query failed');
        
                if($insert){
                    $message[] = 'password changed';
                    header('location:index.php');
                }else{
                    $message[] = 'Failed to change password!';
                }
        }else{
            
        }

    }
    

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
            <h2>Password Change</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <input type="password" class='textbox' name="password" placeholder="Password" id="passwordInput" required="required">
                </div>
                <div class="field">
                    <input type="password" class='textbox' name="cpassword" placeholder="Confirm Password" id="cpassword" required="required">
                </div>
                 <div class="field">
                    <input type="checkbox" onclick="showPass()">Show Password
                </div>
                <?php
                    if(isset($message)){
                        foreach($message as $message){
                            echo '<div class="message" style="color:red; font-size:12px;">'.$message.'</div><br/>';
                        }
                    }
                ?>
                 <div class="field">
                     <button class="buttondeco" name="submit" type="submit"><b>Change Password</b></button>
                </div>
                
        <script src="js/main.js"></script>
    </body>
</html>
