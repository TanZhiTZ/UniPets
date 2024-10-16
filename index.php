<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNIPETS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="img/UniPets.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" 
       src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
    <body>
        <!-- Background -->
        <?php include('background.php'); ?>

        <!-- Header -->
        <div class="header">
            <?php include('header/header.php'); ?>
        </div>

        <!-- Image -->
        <div class="active scroll-up-animation">
            <img class="center-image" src="img/homecats.jpeg" alt="householdpets" style="padding-top: 0;">
        </div>

        <!-- Content -->
         <header class="main">
            <h2 style="text-align: center;"><strong>Give the pets a new home!</strong></h2>
            <p style="text-align: center; margin-left:300px; margin-right: 300px;"><i>At our shelter, we are committed to providing a safe and nurturing environment for animals in need. 
                        Many abandoned pets have endured hardship on the streets, and we are determined to make a difference. 
                        Join us in our mission to give these deserving animals a second chance by helping them find loving homes.</i></p>
         </header>
        
        <!-- Categories -->
        <div id="categories">
            <ul class="header container-fluid" style="width: 50%;" action="pets.php" role="" method="POST">
                <li class="left-right-margin scroll-up-animation" style="transition: .6s; margin-bottom: 20px;">
                    <a href="cat-list.php" class="header"><button class="btn-frame shadow" type="submit"><span><img src="css/img/cat-icon.png" width="100px"/></span></button></a>
                </li>
                <li class="left-right-margin scroll-up-animation" style="transition: .8s;">
                    <a href="dog-list.php" class="header"><button class="btn-frame shadow" type="submit"><span><img src="css/img/dog-icon.png" width="100px"/></span></button></a>
                </li>
                <li class="left-right-margin scroll-up-animation" style="transition: 1s;">
                    <a href="products.php" class="header"><button class="btn-frame shadow"><span><img src="css/img/pet-food.png" width="100px"/></span></button></a>
                </li>
            </ul>
        </div>
       <div style="padding:20px;"></div>
                 
        <!-- Main Content & Books -->
            <div class="main row align-items-start">
                <div class="left-main col-sm" style="min-width: 80%; max-width: auto;">
                    <section>
                        <header style="item-align: center; margin-left:200px; margin-right: 200px;">
                            <h2><strong>Our Goals</strong></h2>
                            <p style=""><i>At our animal shelter, our primary goal is to rescue, rehabilitate, and rehome abandoned and neglected animals. 
                                We strive to provide a safe haven where every animal receives the medical care, nutrition, and love they deserve. 
                                Beyond providing immediate care, we are committed to educating the community about responsible pet ownership and advocating for animal welfare. 
                                Our long-term vision is to reduce the number of homeless animals through spay/neuter programs and community outreach, ultimately creating a world where every pet has a loving home.</i></p>
                        </header>
                    </section>
                </div>
            </div>
            <br/><br/>
            <?php include('header/footer.php'); ?>
        
            
    

    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 500,
            'GRAD' 0,
            'opsz' 48
        }
    </style>

    <script src="js/main.js">
    </script>
    </body>
</html>
