<?php include('config/constants.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>UNIPETS | About Cats and Dogs</title>
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
    <!-- Background -->
    <?php include('background.php'); ?>

    <!-- Header -->
    <div class="header">
        <?php include('header/header.php'); ?>
    </div>

    <!-- Hero Section -->
    <section id="hero">
        <div class="hero-content">
            <h1>Meet Your New Best Friend</h1>
            <p>Prepare for a wonderful journey as you welcome a cat or dog into your family. We’re here to help you every step of the way.</p>
            <br/><br/><a href="pet-list.php" class="btn-primary">Meet Adoptable Pets</a>
        </div>
    </section><hr style="color: white;"/><br/>

    <!-- Understanding Your Pet Section -->
    <section id="understanding-pet">
        <h2 style="text-align: center;">Understand Your Pet</h2>
        <div class="tabs">
            <button class="tab-button active" onclick="openTab(event, 'dogs')">Dogs</button>
            <button class="tab-button" onclick="openTab(event, 'cats')">Cats</button>
        </div>

        <div id="dogs" class="tab-content active">
            <h3 style="text-align: center;">Caring for Dogs</h3>
            <ul class="info-list">
                <li><strong>Temperament:</strong> Dogs thrive on companionship and affection. Make time for play.</li>
                <li><strong>Exercise:</strong> Regular exercise like walks or playtime is key to keeping your dog fit and happy.</li>
                <li><strong>Training:</strong> Basic commands like sit, stay, and come will help build trust and understanding between you and your dog.</li>
            </ul>
        </div>

        <div id="cats" class="tab-content">
            <h3 style="text-align: center;">Caring for Cats</h3>
            <ul class="info-list">
                <li><strong>Temperament:</strong> Cats are independent yet affectionate. They enjoy quiet, cozy spaces.</li>
                <li><strong>Litter Box:</strong> Keep their litter box clean and placed in a calm area.</li>
                <li><strong>Scratching:</strong> Provide scratching posts to help maintain their claws and something for them to scratch on and avoid furniture damage.</li>
            </ul>
        </div>
    </section>

    <!-- Health & Wellness Section -->
    <section id="health-wellness" style="text-align: center;">
        <h2>Health & Wellness</h2>
        <div class="grid">
            <div class="grid-item">
                <h3>Vaccinations</h3>
                <img src="img/about-pets/vaccination.jpg" height="200px" style="border-radius: 5px;"/><br/><br/>
                <p style="color: black;">Ensure that your pet receives timely vaccinations to protect against common illnesses.</p>
            </div>
            <div class="grid-item">
                <h3>Nutrition</h3>
                <img src="img/about-pets/nutrition.jpg" height="200px" style="border-radius: 5px;"/><br/><br/>
                <p style="color: black;">Provide species-appropriate diets. Cats need protein-rich food, while dogs thrive on a balanced, varied diet.</p>
            </div>
            <div class="grid-item">
                <h3>Vet Visits</h3>
                <img src="img/about-pets/vet.jpg" height="200px" style="border-radius: 5px;"/><br/><br/>
                <p style="color: black;">Regular checkups help catch potential issues early and ensure long-term health.</p>
            </div>
            <div class="grid-item">
                <h3>Spaying/Neutering</h3>
                <img src="img/about-pets/spa.jpg" height="200px" style="border-radius: 5px;"/><br/><br/>
                <p style="color: black;">Control the pet population and prevent certain health issues by spaying or neutering your pet.</p>
            </div>
        </div>
    </section>

    <!-- Safe Space at Home Section -->
    <section id="safe-space" style="text-align: center;">
        <h2>Creating a Safe Space at Home</h2>
        <div class="content">
            <div class="home-section">
                <h3>For Dogs</h3>
                <p style="color: black;">Set up a quiet area with their bed, toys, and food. Keep it clutter-free and hazard-free.</p>
            </div>
            <div class="home-section">
                <h3>For Cats</h3>
                <p style="color: black;">Provide a cozy spot with a scratching post, toys, and their litter box in a quiet area of your home.</p>
            </div>
        </div>
    </section>
    
    <br/><br/>

    <!-- Footer -->
    <br/><br/>
    <?php include('header/footer.php'); ?>

    <script src="js/main.js"></script>
</body>
</html>
