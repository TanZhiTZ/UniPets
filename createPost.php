<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $userName = $_POST['userName'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $topicId = 1;

    $sql = "INSERT INTO post (userId, userName, topicId, title, content, dateCreated) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isiss', $userId, $userName, $topicId, $title, $content);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: community-forum.php');
    } else {
        echo "Error creating post.";
    }
}
?>
