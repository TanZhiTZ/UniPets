<?php
include('config/constants.php');

if (!isset($_SESSION['userId'])) {
    echo "NOT_LOGGED_IN";
    exit;
}

$userId = $_SESSION['userId'];

// Get POST data from AJAX request
$accessoriesId = isset($_POST['accessoriesId']) ? intval($_POST['accessoriesId']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

// Check if valid accessoriesId and quantity
if ($accessoriesId > 0 && $quantity > 0) {

    $stmt = $conn->prepare("SELECT quantity FROM cartitem WHERE userId = ? AND accessoriesId = ?");
    $stmt->bind_param("ii", $userId, $accessoriesId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Item exists, fetch the current quantity
        $stmt->bind_result($existingQuantity);
        $stmt->fetch();

        // Update the quantity by adding the new quantity to the existing one
        $newQuantity = $existingQuantity + 1;

        $updateStmt = $conn->prepare("UPDATE cartitem SET quantity = ? WHERE userId = ? AND accessoriesId = ?");
        $updateStmt->bind_param("iii", $quantity, $userId, $accessoriesId);

        if ($updateStmt->execute()) {
            echo "SUCCESS";
        } else {
            echo "ERROR: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO cartitem (userId, accessoriesId, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $accessoriesId, $quantity);
        
        if ($stmt->execute()) {
            echo "SUCCESS";
        } else {
            echo "ERROR: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "ERROR";
}
$conn->close();
?>