<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>UNIPETS | User Profile</title>
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

        <!-- main -->
        <div>
            <div style="padding-left: 115px;">

                <!-- User Profile Frame -->
                <div class="profile-frame">
                    <img src="img/user/user_default.jpg" class="center" style="padding-bottom: 20px;" width="170px;"/>
                    <h2 style="text-align: center; margin-bottom: 20px; color: #5e57c2;">User Profile</h2>
                    <form action="" id="" method="POST" enctype="multipart/form-data">
                        <table style="width:100%;">
                            <!-- First Name -->
                            <tr class="tr-row">
                                <td>First Name:</td>
                                <td><input type="text" class='profile-textbox' name="first_name" placeholder="Enter First Name" required></td>
                            </tr>
                            <!-- Last Name -->
                            <tr class="tr-row">
                                <td>Last Name:</td>
                                <td><input type="text" class='profile-textbox' name="last_name" placeholder="Enter Last Name" required></td>
                            </tr>
                            <!-- User Name -->
                            <tr class="tr-row">
                                <td>User Name:</td>
                                <td><input type="name" class='static-profile-textbox' name="name" placeholder="<?php $userName = $_SESSION['userName']; echo"$userName";?>" readonly></td>
                            </tr>
                            <!-- Email -->
                            <tr class="tr-row">
                                <td>Email:</td>
                                <td><input type="email" class='static-profile-textbox' name="email" placeholder="<?php $userEmail = $_SESSION['userEmail']; echo"$userEmail";?>" readonly></td>
                            </tr>
                            <!-- Pets Interested -->
                            <tr class="tr-row">
                                <td>Pets Interested:</td>
                                <td>
                                    <select name="pets_interested" class='profile-dropdown' required>
                                        <option value="" disabled selected>Select Pets</option>
                                        <option value="cats">Cats</option>
                                        <option value="dogs">Dogs</option>
                                        <option value="both">Both</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- Country -->
                            <tr class="tr-row">
                                <td>Country:</td>
                                <td>
                                    <select name="country" class='profile-dropdown' required>
                                        <option value="" disabled selected>Select Country</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="JP">Japan</option>
                                        <option value="THI">Thailand</option>
                                        <option value="SIN">Singapore</option>
                                        <option value="Other">Others</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- Pets Owned -->
                            <tr class="tr-row">
                                <td>Pets Owned:</td>
                                <td>
                                    <select name="pets_owned" class='profile-dropdown' required>
                                        <option value="" disabled selected>Select Number</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="2">3</option>
                                        <option value="2">4</option>
                                        <option value="2">5</option>
                                        <option value="2">6</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- About Me -->
                            <tr class="tr-row">
                                <td>About Me:</td>
                                <td><textarea name="about_me" class='profile-textbox' rows="4" style="height: 150px; resize: none;" placeholder="Tell us about yourself..." required></textarea></td>
                            </tr>
                        </table>
                    </form>
                </div>

            </div>
        </div>
    <br/><br/>

    <?php include('header/footer.php'); ?>

    </body>
</html>
