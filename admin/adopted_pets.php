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

// Function to delete adopter details and reset adoption status
if (isset($_POST['deleteAdopter'])) {
    $adopterId = $_POST['adopterId'];
    $petId = $_POST['petId'];

    // Delete adopter details
    $deleteAdopterSQL = "DELETE FROM adopterdetails WHERE adopterId = $adopterId";
    if ($conn->query($deleteAdopterSQL) === TRUE) {
        // Reset the adoption status of the pet
        $updatePetStatusSQL = "UPDATE pet SET adoptionStatus = 0 WHERE petId = $petId";
        if ($conn->query($updatePetStatusSQL) === TRUE) {
            echo "Adopter details deleted and pet status updated.";
            header("Refresh:0"); // Refresh the page to reflect changes
        } else {
            echo "Error updating pet adoption status: " . $conn->error;
        }
    } else {
        echo "Error deleting adopter details: " . $conn->error;
    }
}

// Search filter logic
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Retrieve adopter details and corresponding pet data, filtering by search term
$sql = "SELECT a.adopterId, a.firstName, a.lastName, a.phoneNumber, a.address, a.dateAdopted, 
        p.petId, p.petName, p.img, p.species, p.breed, p.age, p.gender, p.description, p.vaccinated 
        FROM adopterdetails a
        INNER JOIN pet p ON a.petId = p.petId
        WHERE a.firstName LIKE '%$searchTerm%'
        OR a.lastName LIKE '%$searchTerm%'
        OR p.petName LIKE '%$searchTerm%'
        OR a.phoneNumber LIKE '%$searchTerm%'
        OR a.address LIKE '%$searchTerm%'
        ";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopted Pets</title>
    <link rel="stylesheet" href="css/adminStyle.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="main-content">
            <h2>Adopted Pets</h2>
            <!-- Search Form -->
            <form method="GET" action="">
                <input type="text" name="search" id="search" placeholder="Search by first name, last name, pet name, phone number, or address" value="<?php echo htmlspecialchars($searchTerm); ?>" style="width: 60%; padding: 10px;">
                <button type="submit">Search</button>
            </form>
            <br>
            <table style='text-align: center; width: 100%;'>
                <thead>
                    <tr>
                        <th>Pet Image</th>
                        <th>Pet Name</th>
                        <th>Species</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Adopter Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Date Adopted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="petsTableBody">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><img src='../img/pets/" . $row['img'] . "' alt='" . $row['petName'] . "' width='100'></td>";
                            echo "<td>" . $row['petName'] . "</td>";
                            echo "<td>" . $row['species'] . "</td>";
                            echo "<td>" . $row['breed'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['firstName'] . " " . $row['lastName'] . "</td>";
                            echo "<td>" . $row['phoneNumber'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['dateAdopted'] . "</td>";
                            echo "<td>";
                            // Delete button form
                            echo "<form method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='adopterId' value='" . $row['adopterId'] . "'>
                                    <input type='hidden' name='petId' value='" . $row['petId'] . "'>
                                    <button type='submit' name='deleteAdopter' onclick='return confirm(\"Are you sure you want to delete this adoption record?\");'>Delete</button>
                                  </form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No adopted pets found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // AJAX search
        function searchPets() {
            let searchInput = document.getElementById('search').value;

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "searchAdoptedPets.php?search=" + searchInput, true);
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // Replace the tbody content based new search results
                    document.getElementById('petsTableBody').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        // listening to eveyr keystroke and trigger a search
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search').addEventListener('input', searchPets);
        });
    </script>
</body>
</html>
