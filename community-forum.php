<?php
include('config/constants.php');

$sql = "SELECT * FROM post";
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

        <?php
            if($count>0) {
                while($row=mysqli_fetch_assoc($res)) {
                    $postId = $row['postId'];
                    $userId = $row['userId'];
                    $userName = $row['userName'];
                    $topicId = $row['topicId'];
                    $title = $row['title'];
                    $content = $row['content'];
                    $dateCreated = $row['dateCreated'];

                    echo "
                    <ul class='forum-posts' id='forum-posts'>
                        <!-- Example forum post -->
                        <li class='forum-post'>
                            <div class='forum-post-details'>
                                <p class='forum-post-title'>$title</p>
                                <p class='forum-post-meta'>Date: $dateCreated <br/> Author: $userName</p>
                            </div>
                            <div class='forum-post-votes'>
                                <span class='thumb'>👍</span><span>like</span>
                            </div>
                        </li>
                    </ul>";
                }
            }
        ?>
    </div>

    <!-- Forum Button -->
    <a href="index.php" class="forum-btn" title="Back to Home">
        <img src="img/homepage-icon.png" alt="Home Page" style="width: 45px; height: 45px;">
    </a>

    <script>
        function showPosts(period) {
            const buttons = document.querySelectorAll('.forum-tabs button');
            buttons.forEach(btn => btn.classList.remove('active'));

            const posts = document.getElementById('forum-posts');

            if (period === 'all') {
                buttons[0].classList.add('active');
                posts.innerHTML = `
                    <li class="forum-post">
                        <div class="forum-post-details">
                            <p class="forum-post-title">First ever forum post</p>
                            <p class="forum-post-meta">ThisUser posted in Community | 3 Comments</p>
                        </div>
                        <div class="forum-post-votes">
                            <span class="thumb">👍</span><span>65</span>
                        </div>
                    </li>
                    <li class="forum-post">
                        <div class="forum-post-details">
                            <p class="forum-post-title">A post about tech news goes here</p>
                            <p class="forum-post-meta">AnotherUser posted in News | 0 Comments</p>
                        </div>
                        <div class="forum-post-votes">
                            <span class="thumb">👍</span><span>32</span>
                        </div>
                    </li>
                `;
            } else if (period === 'week') {
                buttons[1].classList.add('active');
                posts.innerHTML = `
                    <li class="forum-post">
                        <div class="forum-post-details">
                            <p class="forum-post-title">A weekly tech update</p>
                            <p class="forum-post-meta">User2 posted in Updates | 5 Comments</p>
                        </div>
                        <div class="forum-post-votes">
                            <span class="thumb">👍</span><span>45</span>
                        </div>
                    </li>
                `;
            } else if (period === 'month') {
                buttons[2].classList.add('active');
                posts.innerHTML = `
                    <li class="forum-post">
                        <div class="forum-post-details">
                            <p class="forum-post-title">Monthly discussion on AI</p>
                            <p class="forum-post-meta">User3 posted in AI | 10 Comments</p>
                        </div>
                        <div class="forum-post-votes">
                            <span class="thumb">👍</span><span>85</span>
                        </div>
                    </li>
                `;
            }
        }
    </script>
</body>
</html>
