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

// Retrieve adoption applications data
$sql = "SELECT applicationId, userId, petId, petName, applicationDate, applicationStatus FROM adoptionapplication";
$result = $conn->query($sql);

// Function to handle quick application status toggle
if (isset($_POST['toggleStatus'])) {
    $applicationId = $_POST['applicationId'];
    $newStatus = $_POST['applicationStatus'] == 1 ? 0 : 1;
    $updateStatusSQL = "UPDATE adoptionapplication SET applicationStatus = $newStatus WHERE applicationId = $applicationId";
    if ($conn->query($updateStatusSQL) === TRUE) {
        echo "Application status updated successfully.";
        header("Refresh:0");
    } else {
        echo "Error updating application status: " . $conn->error;
    }
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
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="main-content">
            <h2>Adoption Applications</h2>
            <table>
                <thead>
                    <tr>
                        <th>Application ID</th>
                        <th>User ID</th>
                        <th>Pet ID</th>
                        <th>Pet Name</th>
                        <th>Application Date</th>
                        <th>Application Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['applicationId'] . "</td>";
                            
                            // Add a link to the user's profile page
                            echo "<td><a style='color: black;' target='_blank' href='../viewAuthor.php?userId=" . $row['userId'] . "'>" . $row['userId'] . "</a></td>";
                            
                            // Add a link to the pet's profile page
                            echo "<td><a style='color: black;' target='_blank' href='../pet-description.php?pet_id=" . $row['petId'] . "'>" . $row['petId'] . "</a></td>";
                            
                            echo "<td>" . $row['petName'] . "</td>";
                            echo "<td>" . $row['applicationDate'] . "</td>";
                            echo "<td>" . ($row['applicationStatus'] ? '<p style="color: green;">Approved</p>' : '<p style="color: red;">Declined</p>') . "</td>";
                            echo "<td>";
                            
                            // Quick toggle application status form
                            echo "<form method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='applicationId' value='" . $row['applicationId'] . "'>
                                    <input type='hidden' name='applicationStatus' value='" . $row['applicationStatus'] . "'>
                                    <button type='submit' name='toggleStatus'>Toggle Status</button>
                                  </form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No adoption applications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
