<?php
include('config/constants.php');

if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];

    // Fetch the post to edit
    $sql = "SELECT * FROM post WHERE postId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $postId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($res)) {
        if ($row['userId'] == $userId || $role == 'admin') {
            // Display edit form with post data
            $title = $row['title'];
            $content = $row['content'];
        } else {
            echo "You are not authorized to edit this post.";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="css/forumStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="forum-post-form" style="text-align: center;">
        <h2>Edit Post</h2>
        <form action="updatePost.php" method="POST" id="create-post-form">
            <input type="text" name="title" placeholder="Enter post title" value="<?php echo htmlspecialchars($title); ?>" required>
            <textarea name="content" placeholder="Enter post content" rows="5" required><?php echo htmlspecialchars($content); ?></textarea><br/><br/>
            <button type="submit">Update Post</button>
            <input type="hidden" name="postId" value="<?php echo $postId; ?>">
            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
            <input type="hidden" name="userName" value="<?php echo $userName; ?>">
        </form>
    </div>
</body>
</html>
