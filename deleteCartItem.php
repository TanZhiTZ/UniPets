<?php
include('config/constants.php');

if (!isset($_SESSION['userId'])) {
    echo "NOT_LOGGED_IN";
    exit;
}

$userId = $_SESSION['userId'];

$accessoriesId = isset($_POST['accessoriesId']) ? intval($_POST['accessoriesId']) : 0;

//Check if the data exist within the table
if ($accessoriesId > 0 ) {

    $stmt = $conn->prepare("SELECT * FROM cartitem WHERE userId = ? AND accessoriesId = ?");
    $stmt->bind_param("ii", $userId, $accessoriesId);
    $stmt->execute();
    $stmt->store_result();

    //Removing data from table
    if ($stmt->num_rows > 0) {
        $deleteStmt = $conn->prepare("DELETE FROM cartitem WHERE userId = ? AND accessoriesId = ?");
        $deleteStmt->bind_param("ii", $userId, $accessoriesId);

        if ($deleteStmt->execute()) {
            echo "SUCCESS";
        } else {
            echo "ERROR: " . $deleteStmt->error;
        }
        $deleteStmt->close();
    }

} else {
    echo "ERROR";
}
$conn->close();
?>