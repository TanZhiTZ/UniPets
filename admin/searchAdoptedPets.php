<?php
include '../config/constants.php';

// Check if search term is passed via AJAX
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

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

// Generate HTML for the filtered results
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
    echo "<tr><td colspan='11'>No adopted pets found.</td></tr>";
}
?>
