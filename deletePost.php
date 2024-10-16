<?php
include('config/constants.php');

if (isset($_POST['postId']) && $_SESSION['role'] == 'admin') {
    $postId = $_POST['postId'];

    // Prepare the delete query
    $sql = "DELETE FROM post WHERE postId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $postId);

    if (mysqli_stmt_execute($stmt)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>