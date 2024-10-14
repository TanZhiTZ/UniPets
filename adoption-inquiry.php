<?php
include('config/constants.php');

$petId = $_GET['pet_id'];

if (isset($_GET['pet_id']) && isset($_SESSION['userId'])) {
    $petId = $_GET['pet_id'];
    
} else if (isset($_GET['pet_id']) && !isset($_SESSION['userId'])) {
    $petId = $_GET['pet_id'];
    header("location: pet-description.php?pet_id=".$petId);
}

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
</head>
    <body>
        <!-- Background -->
        <?php include('background.php'); ?>
    
        <!-- Header -->
        <div class="header">
                <?php include('header/header.php'); ?>
        </div>

        <main style="margin-top: 30px; background-color: rgba(0, 0, 0, 0.8); border-radius: 10px;box-shadow: 0 0 15px rgba(126, 165, 255, 0.4);">
            <form action="submit-application-form.php?pet_id=<?php echo $petId; ?>&pet_name=<?php echo $petName; ?>" method="POST">
                <section class="intro">
                    <h1>Tell us a bit about yourself:</h1>
                    
                    <p>I'd like to adopt a 
                        <select name="adoptAnimal" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="cat">Cat</option>
                            <option value="dog">Dog</option>
                        </select>.
                    </p>

                    <p>I am looking to adopt for 
                        <select name="adoptionReason" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="myself">Myself</option>
                            <option value="family">My Family</option>
                            <option value="friend">A Friend</option>
                        </select>.
                    </p>

                    <p>I am a 
                        <select name="experienceLevel" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="first-time">First-time pet owner</option>
                            <option value="experienced">Experienced pet owner</option>
                        </select>.
                    </p>

                    <p>I currently have 
                        <select name="currentPets" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="none">No dog(s) or cat(s)</option>
                            <option value="dog">Dog(s)</option>
                            <option value="cat">Cat(s)</option>
                            <option value="both">Both dog(s) and cat(s)</option>
                        </select>.
                    </p>
                </section><hr style="color: white;"/><br/>

                <section class="ideal-cat">
                    <h2>Now let's hear about your ideal cat.</h2>
                    
                    <p>My ideal pet is 
                        <select name="age" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="young">Young</option>
                            <option value="adult">Adult</option>
                            <option value="senior">Senior</option>
                        </select>.
                    </p>

                    <p>I would like to adopt 
                        <select name="gender" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                            <option value="no-preference">No preference</option>
                        </select>.
                    </p>

                    <p>I prefer a cat that is 
                        <select name="size" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="small">Small (5-7 lbs)</option>
                            <option value="medium">Medium (7-11 lbs)</option>
                            <option value="large">Large (11+ lbs)</option>
                        </select>.
                    </p>

                    <p>I would like a cat that has 
                        <select name="hair" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="long">Long hair</option>
                            <option value="short">Short hair</option>
                            <option value="no-preference">No preference</option>
                        </select>.
                    </p>

                    <p>My cat must be 
                        <select name="temperament" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="no-preference">No preference</option>
                            <option value="calm">Calm</option>
                            <option value="playful">Playful</option>
                        </select>.
                    </p>

                    <p>I am 
                        <select name="specialNeeds" class="user-select invalid">
                            <option value="" disabled selected>Please select</option>
                            <option value="open">Open to adopting a cat with special needs</option>
                            <option value="not-open">Not open to special needs</option>
                        </select>.
                    </p>
                </section><hr style="color: white;"/><br/>

                <section class="match" style="text-align: center;">
                    <h3>All done! You were interested in <?php echo $petName; ?>.
                    <br/><br/><button name="submit" type="submit" class="results-btn" id="submit-btn">Submit Adoption Application Form</button><br/><br/>
                    </h3>

                    <img src="img/pets/<?php echo $img; ?>" alt="Cat" class="cat-image" style="border-radius: 5px;">
                </section>
            </form>
        </main>

    <script>
        // Function to check selection and update color
        function checkSelections() {
            const selects = document.querySelectorAll('.user-select');
            
            selects.forEach(select => {
                if (select.value === "") {
                    select.classList.add('invalid');
                    select.classList.remove('valid');
                } else {
                    select.classList.remove('invalid');
                    select.classList.add('valid');
                }
            });
        }

        // Attach event listeners to all select elements
        const selects = document.querySelectorAll('.user-select');
        selects.forEach(select => {
            select.addEventListener('change', checkSelections);
        });
    </script>

    <br/><br/>
        <?php include('header/footer.php'); ?>
    </body>
</html>
