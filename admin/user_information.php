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
            <h2>User Information</h2>
            <!-- Add forms to update/view user info here -->
            <form action="user_information_process.php" method="POST">
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br><br>

                <input type="submit" value="Update User Info">
            </form>
        </div>    
    </div>
</body>
</html>
