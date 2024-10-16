<?php
include('config/constants.php');

$userId = $_SESSION['userId'];
$userName = $_SESSION['userName'];
$role = $_SESSION['role'];

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="forum-container">
        <!-- Forum Post Form -->
        <div class="forum-post-form" style="text-align: center;">
            <h2>Create a New Post</h2>
            <button id="new-post-button">+ New Post</button>
            <form action="createPost.php" method="POST" id="create-post-form" style="display: none;">
                <input type="text" name="title" placeholder="Enter post title" required>
                <textarea name="content" placeholder="Enter post content" rows="5" required></textarea>
                <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                <input type="hidden" name="userName" value="<?php echo $userName; ?>">
                <button type="submit">Post</button>
            </form>
        </div>

        <!-- Forum Posts List -->
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
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
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
                    if ($role == "admin" || $userId == $userIdPost) {
                        echo "<div class='forum-post-options'>
                                <span class='edit-post-btn' onclick='editPost($postId)'>Edit Post</span>--------------------
                                <span class='delete-post-btn' onclick='confirmDelete($postId)'>Delete Post</span>
                              </div>";
                    }

                    echo "</li>";
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
        document.getElementById('new-post-button').addEventListener('click', function() {
        var form = document.getElementById('create-post-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });

        function confirmDelete(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                $.ajax({
                    url: 'deletePost.php',
                    type: 'POST',
                    data: { postId: postId },
                    success: function(response) {
                        if (response === 'success') {
                            $('#post-' + postId).remove();
                        } else {
                            alert('Failed to delete post. Please try again.');
                        }
                    },
                    error: function() {
                        alert('Error occurred while deleting post.');
                    }
                });
            }
        }

        function editPost(postId) {
            // Redirect to the edit page for this post
            window.location.href = 'edit-post.php?postId=' + postId;
        }

        function showPosts(period) {
            $.ajax({
                url: 'fetchPosts.php',
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
