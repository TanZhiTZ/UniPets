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

$showAdopted = isset($_POST['showAdopted']) ? 1 : 0;

// Retrieve pet data
$sql = "SELECT petId, petName, img, species, breed, age, gender, description, vaccinated, adoptionStatus 
        FROM pet";
if (!$showAdopted) {
    $sql .= " WHERE adoptionStatus = 0"; // Only show adopted pets by default
}
$result = $conn->query($sql);


// Function to insert adopter details and update adoption status
if (isset($_POST['submitAdopterDetails'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $petId = $_POST['petId'];
    $petName = $_POST['petName'];

    // Insert adopter details into the 'adopterdetails' table
    $insertAdopterSQL = "INSERT INTO adopterdetails (firstName, lastName, phoneNumber, address, petId, petName) 
                         VALUES ('$firstName', '$lastName', '$phoneNumber', '$address', $petId, '$petName')";
    if ($conn->query($insertAdopterSQL) === TRUE) {
        // Toggle the pet's adoption status
        $toggleStatusSQL = "UPDATE pet SET adoptionStatus = 1 WHERE petId = $petId";
        if ($conn->query($toggleStatusSQL) === TRUE) {
            echo "Adoption details saved and pet status updated successfully.";
            header("Refresh:0");
        } else {
            echo "Error updating adoption status: " . $conn->error;
        }
    } else {
        echo "Error saving adopter details: " . $conn->error;
    }
}

// Function to delete a pet
if (isset($_POST['deletePet'])) {
    $petId = $_POST['petId'];
    $deleteSQL = "DELETE FROM pet WHERE petId = $petId";
    if ($conn->query($deleteSQL) === TRUE) {
        echo "Pet deleted successfully.";
    } else {
        echo "Error deleting pet: " . $conn->error;
    }
}

// Function to update pet details
if (isset($_POST['updatePet'])) {
    $petId = $_POST['petId'];
    $petName = $_POST['petName'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $vaccinated = isset($_POST['vaccinated']) ? 1 : 0;

    $updatePetSQL = "UPDATE pet SET 
                        petName = '$petName', 
                        species = '$species', 
                        breed = '$breed', 
                        age = '$age', 
                        gender = '$gender', 
                        description = '$description',
                        vaccinated = $vaccinated 
                    WHERE petId = $petId";
    
    if ($conn->query($updatePetSQL) === TRUE) {
        echo "Pet information updated successfully.";
        header("Refresh:0");
    } else {
        echo "Error updating pet: " . $conn->error;
    }
}

// Handle pet addition
if (isset($_POST['addPet'])) {
    $petName = $_POST['petName'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $vaccinated = isset($_POST['vaccinated']) ? 1 : 0;

    // Image upload handling
    $targetDir = "../img/pets/";
    $fileName = basename($_FILES["img"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    // Check if the uploaded file is an image
    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)) {
            // Insert new pet into database
            $addPetSQL = "INSERT INTO pet (petName, img, species, breed, age, gender, description, vaccinated, adoptionStatus) 
                        VALUES ('$petName', '$fileName', '$species', '$breed', '$age', '$gender', '$description', $vaccinated, 0)";
            if ($conn->query($addPetSQL) === TRUE) {
                echo "New pet added successfully.";
                header("Refresh:0"); // Refresh the page after successful insertion
            } else {
                echo "Error adding pet: " . $conn->error;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
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

        <!-- Filter to show/hide available pets -->
        <h3>Filter Pets</h3>
        <input type="text" id="searchBar" placeholder="Search for pets..." oninput="searchPets()">
        <form method="POST">
            <label for="showAdopted">Show Adopted Pets:</label>
            <input type="checkbox" name="showAdopted" id="showAdopted" onchange="this.form.submit()" <?php echo $showAdopted ? 'checked' : ''; ?>>
        </form>

        <!-- Add new pet form -->
        <h3>Add New Pet</h3>
        <button onclick="showAddPetForm()">Open Add Pet Form</button><br/><br/>
        <form method="POST" id="addPetModal"  style="display: none;" enctype="multipart/form-data">
            <label for="petName">Pet Name:</label>
            <input type="text" id="petName" name="petName" placeholder="Enter the pet's name" required>

            <label for="species">Species:</label>
            <select id="species" name="species" required>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
                <option value="Others">Others</option>
            </select>

            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" placeholder="Enter the breed" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" placeholder="Enter the pet's age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="♂">♂ Male</option>
                <option value="♀">♀ Female</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter a brief description" required></textarea>

            <label for="vaccinated">Vaccinated:</label>
            <input type="checkbox" id="vaccinated" name="vaccinated"> Yes <br/><br/>

            <label for="img">Pet Image:</label>
            <input type="file" id="img" name="img" required>

            <button onclick="hideAddPetForm()" class="cancel-btn">Close Add Pet Form</button>
            <input type="submit" name="addPet" value="Add Pet">
        </form>

        <!-- Adopter Details Modal (hidden by default) -->
        <div id="adopterModal" style="display:none;">
            <h3>Adopter Details</h3>
            <form method="POST">
                <input type="hidden" name="petId" id="adopterPetId">

                <label for="firstName">Pet Adopting:</label>
                <input type="text" name="petName" id="adopterPetName" readonly>
                
                <label for="firstName">Adopter First Name:</label>
                <input type="text" id="firstName" name="firstName" required>

                <label for="lastName">Adopter Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>

                <label for="phoneNumber">Phone Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>

                <button onclick="hideAdopterForm()" class="cancel-btn">Cancel</button>
                <input type="submit" name="submitAdopterDetails" value="Submit">
            </form>
        </div>

        <!-- Edit pet modal (hidden by default) -->
        <div id="editPetModal" style="display:none;">
            <h3>Edit Pet Information</h3>
            <form method="POST">
                <input type="hidden" name="petId" id="editPetId">

                <label for="editPetName">Pet Name:</label>
                <input type="text" id="editPetName" name="petName" placeholder="Enter the pet's name">

                <label for="editSpecies">Species:</label>
                <select id="editSpecies" name="species">
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="Others">Others</option>
                </select>

                <label for="editBreed">Breed:</label>
                <input type="text" id="editBreed" name="breed" placeholder="Enter the breed">

                <label for="editAge">Age:</label>
                <input type="number" id="editAge" name="age" placeholder="Enter the age">

                <label for="editGender">Gender:</label>
                <select id="editGender" name="gender">
                    <option value="♂">♂ Male</option>
                    <option value="♀">♀ Female</option>
                </select>

                <label for="editDescription">Description:</label>
                <textarea id="editDescription" name="description" placeholder="Enter a description"></textarea>

                <label for="editVaccinated">Vaccinated:</label>
                <input type="checkbox" id="editVaccinated" name="vaccinated"> Yes

                <input type="submit" name="updatePet" value="Update Pet">
            </form>
            <button onclick="hideEditForm()">Cancel</button>
        </div>

            <h2>Pet Information</h2>
            <table>
                <thead>
                    <tr>
                        <th>Pet Image</th>
                        <th>Pet Name</th>
                        <th>Species</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Description</th>
                        <th>Vaccinated</th>
                        <th>Adoption Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><img src='../img/pets/" . $row['img'] . "' alt='" . $row['petName'] . "' width='100'></td>";
                            echo "<td>" . $row['petName'] . "</td>";
                            echo "<td>" . $row['species'] . "</td>";
                            echo "<td>" . $row['breed'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . ($row['vaccinated'] ? 'Yes' : 'No') . "</td>";
                            echo "<td>" . ($row['adoptionStatus'] ? '<p style="color: red;">Adopted</p>' : '<p style="color: green;">Available</p>') . "</td>";
                            echo "<td>";

                            // Quick toggle for Adoption form
                            echo "<button onclick='showAdopterForm(" . json_encode($row) . ")'>Add Adopter</button>";

                            // Edit button (will trigger an inline edit form)
                            echo "<button onclick='showEditForm(" . json_encode($row) . ")'>Edit</button>";
                            // Delete pet form
                            echo "<form method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='petId' value='" . $row['petId'] . "'>
                                    <button type='submit' name='deletePet' onclick='return confirm(\"Are you sure you want to delete this pet?\");'>Delete</button>
                                  </form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No pets found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
        function searchPets() {
            // Get value
            const searchValue = document.getElementById('searchBar').value.toLowerCase();
            
            // Get all rows of the table
            const rows = document.querySelectorAll("tbody tr");
            
            // loop
            rows.forEach(row => {
                // Get the text content of the cells in the row
                const petName = row.cells[1].textContent.toLowerCase();
                const species = row.cells[2].textContent.toLowerCase();
                const breed = row.cells[3].textContent.toLowerCase();
                const age = row.cells[4].textContent.toLowerCase();
                const gender = row.cells[5].textContent.toLowerCase();
                const description = row.cells[6].textContent.toLowerCase();
                
                // Check all fields for search input
                if (petName.includes(searchValue) || species.includes(searchValue) || breed.includes(searchValue) ||
                    age.includes(searchValue) || gender.includes(searchValue) || description.includes(searchValue)) {
                    row.style.display = "";  // Show if matches
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Show edit form with pet data by default
        function showEditForm(pet) {
            document.getElementById('editPetId').value = pet.petId;
            document.getElementById('editPetName').value = pet.petName;
            document.getElementById('editSpecies').value = pet.species;
            document.getElementById('editBreed').value = pet.breed;
            document.getElementById('editAge').value = pet.age;
            document.getElementById('editGender').value = pet.gender;
            document.getElementById('editDescription').value = pet.description;
            document.getElementById('editVaccinated').checked = pet.vaccinated ? true : false;
            document.getElementById('editPetModal').style.display = 'block';
        }

        // Hide edit form
        function hideEditForm() {
            document.getElementById('editPetModal').style.display = 'none';
        }
        
        // Show the adopter form
        function showAdopterForm(pet) {
            document.getElementById('adopterPetId').value = pet.petId;
            document.getElementById('adopterPetName').value = pet.petName;
            document.getElementById('adopterModal').style.display = 'block';
        }

        // Hide the adopter form
        function hideAdopterForm() {
            document.getElementById('adopterModal').style.display = 'none';
        }

        // Show add pet form
        function showAddPetForm() {
            document.getElementById('addPetModal').style.display = 'block';
        }
        
        // Hide add pet form
        function hideAddPetForm() {
            document.getElementById('addPetModal').style.display = 'none';
        }
        </script>
    </div>
</body>
</html>