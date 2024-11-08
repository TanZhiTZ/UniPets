<?php
include('config/constants.php');
ini_set('display_errors', 0);

$role = $_SESSION['role'];
$userId = $_SESSION['userId'];

$period = isset($_GET['period']) ? $_GET['period'] : 'all';
$sql = "";

switch ($period) {
    case 'week':
        $sql = "SELECT * FROM post WHERE dateCreated >= NOW() - INTERVAL 1 WEEK ORDER BY dateCreated DESC";
        break;
    case 'month':
        $sql = "SELECT * FROM post WHERE dateCreated >= NOW() - INTERVAL 1 MONTH ORDER BY dateCreated DESC";
        break;
    default: // all
        $sql = "SELECT * FROM post ORDER BY dateCreated DESC";
        break;
}

$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        $postId = $row['postId'];
        $userIdPost = $row['userId'];
        $userNamePost = $row['userName'];
        $title = $row['title'];
        $content = $row['content'];
        $dateCreated = $row['dateCreated'];

        echo "<li class='forum-post' id='post-$postId'>
                <div class='forum-post-details'>
                    <a href='viewPost.php?postId=$postId' class='forum-post-title'>$title</a>
                    <p class='forum-post-meta'>Date: $dateCreated <br/>
                    Author: <a href='viewAuthor.php?userId=$userIdPost'>$userNamePost</a></p>
                </div>";

        // Allow user to delete/edit if they are the author or admin
        if ($userId == $userIdPost) {
            echo "<div class='forum-post-options'>
                    <span class='edit-post-btn' onclick='editPost($postId)'>Edit Post</span>--------------------
                    <span class='delete-post-btn' onclick='confirmDelete($postId)'>Delete Post</span>
                  </div>";
        } else if ($role == "admin") {
            echo "<div class='forum-post-options'>
                    <span class='delete-post-btn' onclick='confirmDelete($postId)'>Delete Post</span>
                  </div>";
        }

        echo "</li>";
    }
} else {
    echo "<p>No posts available.</p>";
}
?>
