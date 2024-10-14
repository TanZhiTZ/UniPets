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
            <h2>Inventory List</h2>
            <!-- Display list of inventory -->
            <form action="inventory_list_process.php" method="POST">
                <label for="itemName">Item Name:</label>
                <input type="text" id="itemName" name="itemName"><br><br>

                <label for="itemQuantity">Quantity:</label>
                <input type="number" id="itemQuantity" name="itemQuantity"><br><br>

                <input type="submit" value="Update Inventory">
            </form>
        </div>
    </div>
</body>
</html>