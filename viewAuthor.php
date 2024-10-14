<?php
include('config/constants.php');

if(isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    $sql = "SELECT * FROM user WHERE userId = $userId";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $userName = $row['userName'];
        $role = $row['role'];
        $preferredPet = $row['preferredPet'];
        $country = $row['country'];
        $petsOwned = $row['petsOwned'];
        $accountCreationDate = $row['accountCreationDate'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author: <?php echo $userName; ?></title>
    <link rel="stylesheet" href="css/forumStyle.css">
</head>
<body>
    <!-- Back Button -->
    <div>
        <a href="community-forum.php"><button class="back-button" onclick="goBack()">←</button></a>
    </div>

    <div class="author-container">
        <div class="author-card">
            <h1><?php echo $userName; ?></h1>
            <p><strong>Role:</strong> <?php echo $role; ?></p>

            <?php if($country != null): ?>
            <p><strong>Country:</strong> <?php echo $country; ?></p>
            <?php endif; ?>

            <?php if($preferredPet != null): ?>
            <p><strong>Preferred Pet:</strong> <?php echo $preferredPet; ?></p>
            <?php endif; ?>

            <?php if($petsOwned > 0): ?>
                <p><strong>Pets Owned:</strong> <?php echo $petsOwned; ?></p>
            <?php endif; ?>
            <p><strong>Account Created:</strong> <?php echo $accountCreationDate; ?></p>
        </div>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .author-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .author-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        .author-card h1 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #333;
        }
        .author-card p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }
        .author-card p strong {
            color: #333;
        }
        .forum-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .forum-btn:hover {
            background-color: #0056b3;
        }
        img {
            vertical-align: middle;
        }
    </style>
</body>
</html>
