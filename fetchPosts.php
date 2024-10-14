<?php
include('config/constants.php');

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
        $userId = $row['userId'];
        $userName = $row['userName'];
        $title = $row['title'];
        $dateCreated = $row['dateCreated'];

        echo "
        <li class='forum-post'>
            <div class='forum-post-details'>
                <a href='viewPost.php?postId=$postId' class='forum-post-title'>$title</a>
                <p class='forum-post-meta'>Date: $dateCreated <br/> 
                Author: <a href='viewAuthor.php?userId=$userId'>$userName</a></p>
            </div>
            <div class='forum-post-votes'>
                <span class='thumb'>👍</span><span>like</span>
            </div>
        </li>";
    }
} else {
    echo "<p>No posts available for this period.</p>";
}
?>
