<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNIPETS | About Us</title>
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

        <div class="page-wrapper d-flex justify-content-center align-items-center">
        <div class="aboutUs-container mt-5">
            <!-- Our Aim Section -->
            <section id="our-aim" class="mb-5">
                <h2 class="text-center mb-4">OUR AIM</h2>
                <p class="text-center">
                    At UniPets, we are dedicated to ensuring the safety and well-being of pets. 
                    Our aim is to provide a secure platform for pet adoption, where we match loving families with pets in need of a home. 
                    We believe every pet deserves a chance at a happy and healthy life, and we strive to make that a reality.
                </p>
            </section>

            <!-- Founders Section -->
            <section id="founders" class="mb-5">
                <h2 class="text-center mb-4">FOUNDER</h2>
                <div class="row text-center">
                    <div class="col-md-4">
                        <img src="img/founder/founder1.jpg" alt="Founder 1" class="founder-img rounded-circle mb-3">
                        <h5>Tanaka</h5>
                        <p>Founder</p>
                    </div>
                    <div class="col-md-4">
                        <img src="img/founder/founder2.jpg" alt="Founder 2" class="founder-img rounded-circle mb-3">
                        <h5>Robert</h5>
                        <p>Co-Founder</p>
                    </div>
                    <div class="col-md-4">
                        <img src="img/founder/founder3.jpg" alt="Founder 3" class="founder-img rounded-circle mb-3">
                        <h5>Mr. Tan</h5>
                        <p>Chief Veterinary Officer</p>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section id="faq" class="mb-5">
                <h2 class="text-center mb-4">FAQ</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                                How can I adopt a pet?
                            </button>
                        </h2>
                        <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can browse the available pets on our website and apply for adoption. Our team will review your application and guide you through the process to ensure a perfect match.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                                What is the process for ensuring pet safety?
                            </button>
                        </h2>
                        <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We carefully screen all adoption applicants and work closely with veterinary professionals to ensure the health and safety of each pet before and after adoption.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                                How can I contact you for more information?
                            </button>
                        </h2>
                        <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can reach out to us via our contact page. We are here to assist you with any inquiries you may have.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

        <br/><br/>
        <?php include('header/footer.php'); ?>
    </body>
</html>