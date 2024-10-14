<?php
include '../config/constants.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    if ($role != "admin") {
        header('location:../index.php');
    }
} else {
    header('location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/adminStyle.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <?php include('sidebar.php'); ?>
        <div class="main-content">
            <h2>Pet Information</h2>
            <!-- Add forms to update/view pet info here -->
            <form action="pet_information_process.php" method="POST">
                <label for="petName">Pet Name:</label>
                <input type="text" id="petName" name="petName"><br><br>
                
                <label for="petType">Pet Type:</label>
                <input type="text" id="petType" name="petType"><br><br>

                <label for="petAge">Age:</label>
                <input type="number" id="petAge" name="petAge"><br><br>

                <input type="submit" value="Update Pet Info">
            </form>
        </div>
    </div>
</body>
</html>