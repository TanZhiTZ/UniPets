<?php
    include('config/constants.php');

    $petId = $_GET['pet_id'];
    $petName = $_GET['pet_name'];
    $userId = $_SESSION['userId'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $querySelect = "SELECT * FROM adoptionapplication WHERE userId = '$userId' & petId = '$petId'";
        $res = mysqli_query($conn, $querySelect);
        $count = mysqli_num_rows($res);

        if ($count == 0) {
            $sql = "INSERT INTO adoptionapplication (userId, petId, petName, applicationStatus) VALUES ('$userId', '$petId', '$petName', '1')";
            $res = mysqli_query($conn, $sql);
    
            echo '<script type="text/javascript">';
            echo 'alert("Form submitted!");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("You have already submitted once!");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        }
    }
?>