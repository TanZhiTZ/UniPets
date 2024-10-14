<?php
include('config/constants.php');

$sql = "SELECT * FROM post ORDER BY dateCreated DESC";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIPETS | Community Forum</title>
    <link rel="stylesheet" href="css/forumStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>
    <div class="forum-container">
        <div class="forum-header">
            <h1>Latest</h1>
            <div class="forum-tabs">
                <button class="active" onclick="showPosts('all')">All</button>
                <button onclick="showPosts('week')">This Week</button>
                <button onclick="showPosts('month')">This Month</button>
            </div>
        </div>

        <ul class="forum-posts" id="forum-posts">
            <?php
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
                    </li>";
                }
            } else {
                echo "<p>No posts available.</p>";
            }
            ?>
        </ul>
    </div>

    <!-- Forum Button -->
    <a href="index.php" class="forum-btn" title="Back to Home">
        <img src="img/homepage-icon.png" alt="Home Page" style="width: 45px; height: 45px;">
    </a>

    <script>
        function showPosts(period) {
            $.ajax({
                url: 'fetchPosts.php', // PHP file that fetches posts based on the period
                type: 'GET',
                data: { period: period },
                success: function(data) {
                    $('#forum-posts').html(data);
                    $('.forum-tabs button').removeClass('active');
                    if (period === 'all') {
                        $('.forum-tabs button:first').addClass('active');
                    } else if (period === 'week') {
                        $('.forum-tabs button:nth-child(2)').addClass('active');
                    } else if (period === 'month') {
                        $('.forum-tabs button:last').addClass('active');
                    }
                },
                error: function() {
                    $('#forum-posts').html("<p>Error loading posts.</p>");
                }
            });
        }
    </script>
</body>
</html>
