<?php
include '../config/constants.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    $userId = $_SESSION['userId'];

    if ($role != "admin") {
        header('location:../index.php');
    }
} else {
    header('location:../index.php');
}

// Retrieve user data
$sql = "SELECT userId, userName, email, firstName, lastName, preferredPet, country, petsOwned, aboutMe, role, accountCreationDate FROM user";
$result = $conn->query($sql);

// Function to delete a user
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['userId'];
    $deleteSQL = "DELETE FROM user WHERE userId = $userId";
    if ($conn->query($deleteSQL) === TRUE) {
        echo "User deleted successfully.";
        header("Refresh:0");
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Function to update user details
if (isset($_POST['updateUser'])) {
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'] ? $_POST['firstName'] : NULL;
    $lastName = $_POST['lastName'] ? $_POST['lastName'] : NULL;
    $preferredPet = $_POST['preferredPet'] ? $_POST['preferredPet'] : NULL;
    $country = $_POST['country'] ? $_POST['country'] : NULL;
    $aboutMe = $_POST['aboutMe'] ? $_POST['aboutMe'] : NULL;

    $updateUserSQL = "UPDATE user SET 
                        firstName = '$firstName', 
                        lastName = '$lastName', 
                        preferredPet = '$preferredPet', 
                        country = '$country', 
                        aboutMe = '$aboutMe'
                    WHERE userId = $userId";
    
    if ($conn->query($updateUserSQL) === TRUE) {
        echo "User information updated successfully.";
        header("Refresh:0");
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Information</title>
    <link rel="stylesheet" href="css/adminStyle.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="main-content">

            <!-- Edit user modal (hidden by default) -->
            <div id="editUserModal" style="display:none;">
                <h3>Edit User Information</h3>
                <form method="POST">
                    <input type="hidden" name="userId" id="editUserId">

                    <label for="editFirstName">First Name:</label>
                    <input type="text" id="editFirstName" name="firstName"><br><br>

                    <label for="editLastName">Last Name:</label>
                    <input type="text" id="editLastName" name="lastName"><br><br>

                    <label for="editPreferredPet">Preferred Pet:</label>
                    <input type="text" id="editPreferredPet" name="preferredPet"><br><br>

                    <label for="editCountry">Country:</label>
                    <input type="text" id="editCountry" name="country"><br><br>

                    <label for="editAboutMe">About Me:</label>
                    <textarea id="editAboutMe" name="aboutMe"></textarea><br><br>

                    <button onclick="hideEditForm()" class="cancel-btn">Cancel</button>
                    <input type="submit" name="updateUser" value="Update User">
                </form>
            </div>

            <h2>User Information</h2>
            <table style='text-align: center; width: 100%;'>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Preferred Pet</th>
                        <th>Country</th>
                        <th>Pets Owned</th>
                        <th>About Me</th>
                        <th>Role</th>
                        <th>Account Creation Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['userId'] . "</td>";
                            echo "<td>" . $row['userName'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['firstName'] . "</td>";
                            echo "<td>" . $row['lastName'] . "</td>";
                            echo "<td>" . $row['preferredPet'] . "</td>";
                            echo "<td>" . $row['country'] . "</td>";
                            echo "<td>" . $row['petsOwned'] . "</td>";
                            echo "<td>" . $row['aboutMe'] . "</td>";
                            echo "<td>" . $row['role'] . "</td>";
                            echo "<td>" . $row['accountCreationDate'] . "</td>";
                            echo "<td>";

                            // Edit button (will trigger an inline edit form)
                            echo "<button onclick='showEditForm(" . json_encode($row) . ")'>Edit</button>";
                            // Delete user form
                            echo "<form method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='userId' value='" . $row['userId'] . "'>";
                            if ($userId != $row['userId']) {
                                echo "<button type='submit' name='deleteUser' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>";
                            }
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
        // Show edit form with populated data
        function showEditForm(user) {
            document.getElementById('editUserId').value = user.userId;
            document.getElementById('editFirstName').value = user.firstName;
            document.getElementById('editLastName').value = user.lastName;
            document.getElementById('editPreferredPet').value = user.preferredPet;
            document.getElementById('editCountry').value = user.country;
            document.getElementById('editAboutMe').value = user.aboutMe;
            document.getElementById('editUserModal').style.display = 'block';
        }

        // Hide edit form
        function hideEditForm() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        </script>
    </div>
</body>
</html>
