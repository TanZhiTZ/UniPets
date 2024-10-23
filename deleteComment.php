<?php
include('config/constants.php');

if (isset($_POST['commentId']) && $_SESSION['role'] == 'admin') {
    $commentId = $_POST['commentId'];

    // Prepare the delete query
    $sql = "DELETE FROM comment WHERE commentId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $commentId);

    if (mysqli_stmt_execute($stmt)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
