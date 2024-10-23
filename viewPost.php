<?php
include('config/constants.php');
ini_set('display_errors', 0);

$role = $_SESSION['role'];

if(isset($_GET['postId'])) {
    $postId = $_GET['postId'];

    $sql = "SELECT * FROM post WHERE postId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $content = $row['content'];
        $dateCreated = $row['dateCreated'];
        $userName = $row['userName'];
        $userId = $row['userId'];
    } else {
        die("Post not found.");
    }
}

if(isset($_POST['submit_comment'])) {
    $commentContent = $_POST['comment'];
    // Sanitizing
    $commentContent = htmlspecialchars($commentContent, ENT_QUOTES, 'UTF-8');
    
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $sqlComment = "INSERT INTO comment (postId, userId, content, dateCommented) VALUES (?, ?, ?, NOW())";
        $stmtComment = mysqli_prepare($conn, $sqlComment);
        mysqli_stmt_bind_param($stmtComment, "iis", $postId, $userId, $commentContent);
        
        if(mysqli_stmt_execute($stmtComment)) {
            header("Location: viewPost.php?postId=$postId");
            exit();
        } else {
            echo "<p>Error posting comment. Please try again.</p>";
        }
    } else {
        echo "<p style='text-align: center; color: red;'>Please login to comment.</p>";
    }
}

$sqlComments = "SELECT c.commentId, c.content, c.dateCommented, u.userName FROM comment c JOIN user u ON c.userId = u.userId WHERE c.postId = ? ORDER BY c.dateCommented DESC";
$stmtComments = mysqli_prepare($conn, $sqlComments);
mysqli_stmt_bind_param($stmtComments, "i", $postId);
mysqli_stmt_execute($stmtComments);
$resComments = mysqli_stmt_get_result($stmtComments);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> | UniPets Forum</title>
    <link rel="stylesheet" href="css/forumStyle.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .post-container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .post-details h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .post-content {
            margin: 20px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        .comment-section {
            margin-top: 40px;
        }
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #218838;
        }
        .comments-display {
            margin-top: 40px;
        }
        .comments-display h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .comment {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .comment-content {
            font-size: 14px;
            margin-bottom: 8px;
        }
        .comment-meta {
            font-size: 12px;
            color: #555;
        }
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <div>
        <a href="community-forum.php"><button class="back-button">←</button></a>
    </div>
    
    <div class="post-container">
        <!-- Post content -->
        <div class="post-details">
            <h1><?php echo htmlspecialchars($title); ?></h1>
            <p>By <a href="viewAuthor.php?userId=<?php echo $userId; ?>"><?php echo htmlspecialchars($userName); ?></a> | Date: <?php echo htmlspecialchars($dateCreated); ?></p>
            <div class="post-content"><?php echo nl2br(htmlspecialchars($content)); ?></div>
        </div>

        <!-- Comment Form -->
        <div class="comment-section">
            <h2>Leave a Comment</h2>
            <form action="" method="POST" class="comment-form">
                <textarea name="comment" rows="5" placeholder="Write your comment here..." required></textarea>
                <button type="submit" name="submit_comment">Post Comment</button>
            </form>
        </div>

        <!-- Display Comments -->
        <div class="comments-display">
            <h2>Comments</h2>
            <?php
            if (mysqli_num_rows($resComments) > 0) {
                while ($comment = mysqli_fetch_assoc($resComments)) {
                    $commentId = $comment['commentId'];
            
                    echo "<div class='comment' id='comment-$commentId'>
                            <p class='comment-content'>" . htmlspecialchars($comment['content']) . "</p>
                            <p class='comment-meta'>By: " . htmlspecialchars($comment['userName']) . " on " . htmlspecialchars($comment['dateCommented']) . "</p>";
            
                    // Display delete button if user is admin
                    if ($_SESSION['role'] == 'admin') {
                        echo "<span class='delete-comment-btn' onclick='confirmDeleteComment($commentId)'>Delete Comment</span>";
                    }
            
                    echo "</div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }
            ?>
        </div>
    </div>

<script>
    function confirmDeleteComment(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            $.ajax({
                url: 'deleteComment.php',
                type: 'POST',
                data: { commentId: commentId },
                success: function(response) {
                    if (response === 'success') {
                        // Remove the deleted comment from the DOM
                        $('#comment-' + commentId).remove();
                    } else {
                        alert('Failed to delete comment. Please try again.');
                    }
                },
                error: function() {
                    alert('Error occurred while deleting comment.');
                }
            });
        }
    }
</script>

</body>
</html>
