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
    <section id="safe-space">
        <h2 style="text-align: center;">Facts and way to take care of newly adopted pets</h2>
        <div class="content">
            <div class="home-section">
            <h2>1. Preparing for the Arrival</h2>
                <ul>
                    <li><strong>Comfortable Environment:</strong> Prepare a cozy bed, food and water bowls, and a quiet place where they feel secure. Dogs may appreciate a crate for training and comfort, while cats will appreciate a quiet, secluded spot to adjust.</li>
                    <li><strong>Pet-Proofing:</strong> Check for hazardous items (electrical cords, small objects, toxic plants) and secure them out of reach. Keep cleaning supplies, medications, and human foods stored away as many can be toxic to pets.</li>
                    <li><strong>Basic Supplies:</strong>
                        <ul>
                            <li><strong>Cats:</strong> Litter box, scratching posts, interactive toys.</li>
                            <li><strong>Dogs:</strong> Leash, collar, durable toys, possibly a crate or bed.</li>
                        </ul>
                    </li>
                </ul>

                <h2>2. Building Trust and Bonding</h2>
                <ul>
                    <li><strong>Routine and Consistency:</strong> Keep feeding, potty breaks, and playtimes consistent to establish a sense of security.</li>
                    <li><strong>Positive Reinforcement:</strong> Reward good behavior with treats, praise, and petting to build a strong bond. This also helps pets learn desirable behaviors faster.</li>
                    <li><strong>Personal Space:</strong> Especially for cats, it’s essential to give them space to explore on their own. Avoid forcing interactions; let them come to you.</li>
                </ul>

                <h2>3. Basic Healthcare</h2>
                <ul>
                    <li><strong>Veterinary Visits:</strong> Schedule a wellness exam within the first week. Routine checkups every six months to a year are recommended. This includes vaccinations, parasite control, and health screenings.</li>
                    <li><strong>Spaying/Neutering:</strong> This not only prevents unwanted litters but can also reduce behavioral issues and lower the risk of certain cancers.</li>
                    <li><strong>Grooming:</strong>
                        <ul>
                            <li><strong>Cats:</strong> Brush regularly to minimize hairballs and maintain coat health. Some cats may need nail trims if they don’t naturally wear them down.</li>
                            <li><strong>Dogs:</strong> Brush based on coat type, bathe as needed, and trim nails every 3-4 weeks to avoid overgrowth and discomfort.</li>
                        </ul>
                    </li>
                    <li><strong>Dental Care:</strong> Brush their teeth a few times a week or use dental chews to prevent gum disease, which is common in both cats and dogs.</li>
                </ul>

                <h2>4. Proper Nutrition</h2>
                <ul>
                    <li><strong>Quality Food:</strong> Feed high-quality pet food suited to their age, size, and breed. Many cats and dogs are sensitive to low-quality fillers and artificial ingredients.</li>
                    <li><strong>Meal Times:</strong> Avoid overfeeding by adhering to recommended portion sizes. Some cats do well with free feeding, but dogs should have set meal times to avoid bloating and overeating.</li>
                    <li><strong>Special Diets:</strong> Older pets or those with health issues may need specific diets, so consult with a veterinarian for recommendations.</li>
                </ul>

                <h2>5. Exercise and Mental Stimulation</h2>
                <ul>
                    <li><strong>Daily Exercise:</strong>
                        <ul>
                            <li><strong>Dogs:</strong> At least one daily walk, but active breeds may require more. Provide space to run and play or consider a dog park for socialization.</li>
                            <li><strong>Cats:</strong> Even indoor cats need exercise. Use toys like feather wands, laser pointers, or automated cat toys to keep them engaged.</li>
                        </ul>
                    </li>
                    <li><strong>Mental Enrichment:</strong>
                        <ul>
                            <li><strong>Cats:</strong> Puzzle feeders, treat-dispensing toys, and cat towers or shelves for climbing and exploring.</li>
                            <li><strong>Dogs:</strong> Hide-and-seek games, training sessions, interactive toys, and basic obedience exercises keep them mentally engaged.</li>
                        </ul>
                    </li>
                </ul>

                <h2>6. Training and Behavior Management</h2>
                <ul>
                    <li><strong>Training Basics:</strong>
                        <ul>
                            <li><strong>Dogs:</strong> Focus on obedience training—sit, stay, come, and leash walking.</li>
                            <li><strong>Cats:</strong> While cats are often more independent, you can train them to come when called, use scratching posts, and stay off certain surfaces.</li>
                        </ul>
                    </li>
                    <li><strong>Handling Behavioral Issues:</strong>
                        <ul>
                            <li><strong>Dogs:</strong> Barking, jumping, and chewing can often be managed through redirection and positive reinforcement.</li>
                            <li><strong>Cats:</strong> Litter box issues, scratching furniture, or excessive meowing can usually be addressed by meeting their needs and adjusting the environment.</li>
                        </ul>
                    </li>
                    <li><strong>Socialization:</strong> Expose pets to various environments, people, and other animals at a comfortable pace. This helps them feel confident and reduces anxiety.</li>
                </ul>

                <h2>7. Recognizing and Addressing Health Issues</h2>
                <ul>
                    <li><strong>Common Cat Issues:</strong> Hairballs, dental disease, and obesity are common. Watch for signs of illness like hiding, changes in litter box habits, or decreased grooming.</li>
                    <li><strong>Common Dog Issues:</strong> Arthritis, ear infections, and dental issues are typical in dogs. Monitor for limping, itching, or changes in energy and eating habits.</li>
                    <li><strong>Signs of Distress:</strong> Watch for symptoms like lethargy, loss of appetite, or vomiting, and consult a vet if anything unusual appears.</li>
                </ul>

                <h2>8. Safety and Outdoor Precautions</h2>
                <ul>
                    <li><strong>Microchipping:</strong> Microchip your pet and keep ID tags up to date to help ensure a safe return if they get lost.</li>
                    <li><strong>Leash and Harness:</strong>
                        <ul>
                            <li><strong>Dogs:</strong> Always use a secure harness or collar and leash when outside.</li>
                            <li><strong>Cats:</strong> If allowing them outdoors, a secure harness and leash prevent escapes and keep them safe.</li>
                        </ul>
                    </li>
                    <li><strong>Temperature Safety:</strong> In hot weather, provide plenty of water and limit outdoor time. During colder months, ensure they stay warm, especially short-haired breeds.</li>
                </ul>
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
