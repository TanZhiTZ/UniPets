<?php
include('config/constants.php');

$petId = $_GET['pet_id'];

if (isset($_SESSION['userId']))
$userId = $_SESSION['userId'];

$sql = "SELECT * FROM pet WHERE petId='$petId'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count>0)
{
    while($row=mysqli_fetch_assoc($res))
    {
        $petId = $row['petId'];
        $petName = $row['petName'];
        $img = $row['img'];
        $species = $row['species'];
        $breed = $row['breed'];
        $age = $row['age'];
        $gender = $row['gender'];
        $description = $row['description'];
        $vaccinated = $row['vaccinated'];

        if ($gender == "♂") {
            $gender = "Male";
        } else if ($gender == "♀") {
            $gender = "Female";
        }

        if ($vaccinated) {
            $vaccinated = "Vaccinated";
        } else {
            $vaccinated = "Is not vaccinated";
        }
    }
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
        <script type="text/javascript" 
       src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
       <style>
        .image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('img/pets/<?php echo $img; ?>');
            background-size: cover;
            background-position: center;
            filter: blur(20px);
            z-index: 1;
        }
        </style>
</head>
    <body>
        <!-- Background -->
        <?php include('background.php'); ?>
    
        <!-- Header -->
        <div class="header">
                <?php include('header/header.php'); ?>
        </div>

        <!-- Back Button -->
        <div>
            <a href="pet-list.php"><button class="back-button" onclick="goBack()"><</button></a>
        </div>

        <!-- Pet Image -->
        <div class='image-container'>
            <img src='img/pets/<?php echo"$img";?>' alt='<?php echo"$petName";?>'>
        </div>
        
        <!-- Pet Information -->
        <div class="profile-container">
            <div class="profile-left">
                <h1><?php echo"$petName";?></h1>
                <p><b>Breed : </b><?php echo"$breed";?></p>
                <div class="profile-details">
                    <p><b>Gender : </b><?php echo "$gender";?></p>
                </div>

                <br/>
                <hr/>
                <div class="profile-about">
                    <h2 style="margin-left: -10px;">About</h2>
                    <p style="margin-top: -20px;"><?php echo"$description";?></p>
                    <br/>
                    
                <hr/>
                <br/>
                    <p><strong>Health</strong></p>
                    <p><?php echo"$vaccinated";?></p>
                </div>
                <div class="profile-footer">
                    <p style="color: red;">UniPets recommends that you should always take reasonable security steps before making online payments.</p>
                </div>
            </div>
            <div class="profile-right">
                <div class="profile-call-to-action">
                    <h2>Considering <?php echo"$petName";?> for adoption?</h2>
                    <?php 
                        $querySelect = "SELECT * FROM adoptionapplication WHERE userId = '$userId' && petId = '$petId'";
                        $res = mysqli_query($conn, $querySelect);
                        $count = mysqli_num_rows($res);

                        if ($count == 0) {
                            if (isset($_SESSION['userId'])) {
                                echo "<a href='adoption-inquiry.php?pet_id=$petId' style='text-decoration: none;'>
                                    <button class='cta-button inquiry'>Start Your Inquiry</button></a>";
                            } else {
                                echo "<a style='text-decoration: none;'>
                                    <button class='cta-button inquiry' style='color: grey;' inactive>Login to start inquiry</button></a>";
                            }
                        } else {
                            echo "<a style='text-decoration: none;'>
                                <button class='cta-button inquiry' style='color: red;' disabled>Inquiry Submitted</button></a>";
                        }

                    ?>
                    
                    <a href="about-pets.php" style="text-decoration: none;"><button class="cta-button faq">Read FAQs</button></a>
                    <div class="cta-actions">
                        <!-- <button class="cta-button favorite">❤ Favorite</button> -->
                    </div>
                </div>
            </div>
        </div>
        
        
        <br/><br/>
        <?php include('header/footer.php'); ?>
    </body>
</html>
