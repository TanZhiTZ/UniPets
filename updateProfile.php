<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['userId'];

    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $petsInterested = mysqli_real_escape_string($conn, $_POST['pets_interested']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $petsOwned = mysqli_real_escape_string($conn, $_POST['pets_owned']);
    $aboutMe = isset($_POST['about_me']) && !empty($_POST['about_me']) ? mysqli_real_escape_string($conn, $_POST['about_me']) : null;

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
