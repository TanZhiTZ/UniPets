<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['userId'];

    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');

    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $lastName = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');

    $petsInterested = mysqli_real_escape_string($conn, $_POST['pets_interested']);
    $petsInterested = htmlspecialchars($petsInterested, ENT_QUOTES, 'UTF-8');

    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $country = htmlspecialchars($country, ENT_QUOTES, 'UTF-8');

    $petsOwned = mysqli_real_escape_string($conn, $_POST['pets_owned']);
    $petsOwned = htmlspecialchars($petsOwned, ENT_QUOTES, 'UTF-8');

    $aboutMe = isset($_POST['about_me']) && !empty($_POST['about_me']) ? mysqli_real_escape_string($conn, $_POST['about_me']) : null;
    $aboutMe = htmlspecialchars($aboutMe, ENT_QUOTES, 'UTF-8');

    // Load bad words.txt file
    $badWordsFilePath = "badwords.txt";

    function loadBadWords($filePath) {
        if (!file_exists($filePath)) {
            return [];
        }

        // Read the file and split into an array
        $badWords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        return $badWords;
    }

    function containsInappropriateWords($string, $bad) {
        foreach ($bad as $word) {
            if (stripos($string, $word) !== false) {
                return true; // Inappropriate word found
            }
        }
        return false;
    }

    $badWords = loadBadWords($badWordsFilePath);
    // Check for bad words
    if (containsInappropriateWords($firstName, $badWords)) {
        echo '<script> alert("Invalid name!");
        window.location.href = "user-profile.php"; </script>';
        exit();
    }
    if (containsInappropriateWords($lastName, $badWords)) {
        echo '<script> alert("Invalid name!");
        window.location.href = "user-profile.php"; </script>';
        exit();
    }
    if (containsInappropriateWords($petsInterested, $badWords)) {
        echo '<script> alert("Invalid content! Bad words detected!");
        window.location.href = "user-profile.php"; </script>';
        exit();
    }
    if (containsInappropriateWords($country, $badWords)) {
        echo '<script> alert("Invalid country! Bad words detected!");
        window.location.href = "user-profile.php"; </script>';
        exit();
    }
    if (containsInappropriateWords($aboutMe, $badWords)) {
        echo '<script> alert("Invalid content! Bad words detected!");
        window.location.href = "user-profile.php"; </script>';
        exit();
    }

    // Build SQL query for update
    $sql = "UPDATE user SET 
                firstName = '$firstName', 
                lastName = '$lastName', 
                preferredPet = '$petsInterested', 
                country = '$country', 
                petsOwned = '$petsOwned', 
                aboutMe = ". ($aboutMe === null ? "NULL" : "'$aboutMe'") ."
            WHERE userId = '$userId'";

    if (mysqli_query($conn, $sql)) { ?>
        <script>
            alert("Profile Updated.");
            setTimeout(function () {
                window.location.href= 'user-profile.php';
            },700); 
        </script>
        <body onload="setTimeout"></body>
   <?php
    } else { ?>
        <script>
            alert("Update Failed.");
            setTimeout(function () {
                window.location.href= 'index.php';
            },700); 
        </script>
        <body onload="setTimeout"></body>
   <?php
    }
}
?>
