<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize content
    $postId = $_POST['postId'];
    $postId = htmlspecialchars($postId, ENT_QUOTES, 'UTF-8');

    $title = $_POST['title'];
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

    $content = $_POST['content'];
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

    $userId = $_SESSION['userId'];
    $userId = htmlspecialchars($userId, ENT_QUOTES, 'UTF-8');

    $role = $_SESSION['role'];
    $role = htmlspecialchars($role, ENT_QUOTES, 'UTF-8');

    // Load bad words.txt file
    $badWordsFilePath = "badwords.txt";

    function loadBadWords($filePath) {
        if (!file_exists($filePath)) {
            return [];
        }

        // Read the file and split into an array
        $badWords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        return $badWords;
    }

    function containsInappropriateWords($string, $bad) {
        foreach ($bad as $word) {
            if (stripos($string, $word) !== false) {
                return true; // Inappropriate word found
            }
        }
        return false;
    }

    $badWords = loadBadWords($badWordsFilePath);
    // Check for bad words
    if (containsInappropriateWords($title, $badWords)) {
        echo '<script> alert("Invalid title!");
        window.location.href = "community-forum.php"; </script>';
        exit();
    }
    if (containsInappropriateWords($content, $badWords)) {
        echo '<script> alert("Invalid content! Bad words detected!");
        window.location.href = "community-forum.php"; </script>';
        exit();
    }

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
