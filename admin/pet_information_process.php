<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petName = $_POST['petName'];
    $petType = $_POST['petType'];
    $petAge = $_POST['petAge'];

    // Database connection & update logic here
    // Example:
    // $query = "UPDATE pets SET name='$petName', type='$petType', age='$petAge' WHERE id=1";

    echo "Pet Information Updated!";
}
?>
