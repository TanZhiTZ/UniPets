<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postId = $_POST['postId'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];

    // Allow update if the user is the post author or an admin
    $sql = "SELECT userId FROM post WHERE postId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $postId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($res)) {
        if ($row['userId'] == $userId || $role == 'admin') {
            // Update the post
            $updateSql = "UPDATE post SET title = ?, content = ? WHERE postId = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, 'ssi', $title, $content, $postId);

            if (mysqli_stmt_execute($updateStmt)) {
                header('Location: community-forum.php');
            } else {
                echo "Error updating post.";
            }
        } else {
            echo "You are not authorized to edit this post.";
        }
    }
}
?>
