<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $userName = $_POST['userName'];
    
    $title = $_POST['title'];
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

    $content = $_POST['content'];
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

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
