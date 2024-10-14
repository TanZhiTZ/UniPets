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
            <h2>Adoption Applications</h2>
            <!-- Display list of applications -->
            <table>
                <tr>
                    <th>Application ID</th>
                    <th>User ID</th>
                    <th>Pet ID</th>
                    <th>Status</th>
                </tr>
                <!-- Populate with application data -->
            </table>
        </div>
    </div>
</body>
</html>