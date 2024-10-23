<?php include('config/constants.php');

$userId = $_SESSION['userId'];

$sql = "SELECT * FROM user WHERE userId = '$userId'";
$res = mysqli_query($conn, $sql);

if ($res == true && mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    
    $firstName = isset($row['firstName']) ? $row['firstName'] : "";
    $lastName = isset($row['lastName']) ? $row['lastName'] : "";
    $petsInterested = isset($row['preferredPet']) ? $row['preferredPet'] : "";
    $country = isset($row['country']) ? $row['country'] : "";
    $petsOwned = isset($row['petsOwned']) ? $row['petsOwned'] : "";
    $aboutMe = isset($row['aboutMe']) ? $row['aboutMe'] : "";
}

// Fetch purchase data for the user
$sql = "SELECT * FROM purchaseorder WHERE userId = '$userId' ORDER BY orderDate DESC";
$purchaseRes = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNIPETS | User Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
<body style="justify-content: center; align-items: center;">
    <!-- Background -->
    <?php include('background.php'); ?>

        <!-- Header -->
        <div class="header">
            <?php include('header/header.php'); ?>
        </div>

        <!-- Display Adoption Application -->
        <?php
            $userId = $_SESSION['userId'];

            $sql = "SELECT * FROM adoptionapplication WHERE userId = '$userId' && applicationStatus = '1'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            
            if ($res == true) {
                
                if ($count > 0) {
                    while($row=mysqli_fetch_assoc($res)) {
                        $applicationDate = $row['applicationDate'];
                        $petName = $row['petName'];
                        $petId = $row['petId'];
    
                        // Convert applicationDate and current date to DateTime objects
                        $applicationDateTime = new DateTime($applicationDate);
                        $currentDateTime = new DateTime();  // gets the current date and time
    
                        $dateDifference = $currentDateTime->diff($applicationDateTime)->days;
    
                        // Check for 14 days validity
                        if ($dateDifference <= 14) {
                            $daysRemaining = 14 - $dateDifference;
                            
                            echo "
                            <div class='alert alert-success' style='margin: 20px; padding: 20px; border-radius: 10px;'>
                                <h4>Your adoption application for <a href='pet-description.php?pet_id=$petId' style='font-size: 20px; color: #3b85b6; text-decoration: none;'><strong>$petName</strong></a> is submitted!</h4>
                                <p style='color: black;'>Application Date: ".date('F j, Y, g:i a', strtotime($applicationDate))."</p>
                                <p style='color: black;'>Days left before application expires: <span style='color: red;' id='countdown'>$daysRemaining</span> days</p>
                            </div>";
    
                            
                        }
                    }
                } else {
                    // No application found for the user
                    echo "<div class='alert alert-info' style='margin: 20px;'>You have no recent adoption applications.</div>";
                }
            } else {
                // Error in query execution
                echo "<div class='alert alert-danger' style='margin: 20px;'>Error fetching application details. Please try again later.</div>";
            }
        ?>

        <!-- Main User Profile Section -->
        <div>
            <div style="padding-left: 115px;">
                <!-- User Profile Frame -->
                <div class="profile-frame">
                    <!-- <img src="img/user/user_default.jpg" class="center" style="padding-bottom: 20px;" width="170px;"/> -->
                    <h2 style="text-align: center; margin-bottom: 20px; color: #5e57c2;">User Profile</h2>
                    <form action="updateProfile.php" id="userProfileForm" method="POST">
                        <table style="width:100%;">
                            <!-- First Name -->
                            <tr class="tr-row">
                                <td>First Name:</td>
                                <td><input type="text" class='profile-textbox' name="first_name" value="<?php echo $firstName; ?>" placeholder="Enter First Name" required></td>
                            </tr>
                            <!-- Last Name -->
                            <tr class="tr-row">
                                <td>Last Name:</td>
                                <td><input type="text" class='profile-textbox' name="last_name" value="<?php echo $lastName; ?>" placeholder="Enter Last Name" required></td>
                            </tr>
                            <!-- User Name -->
                            <tr class="tr-row">
                                <td>User Name:</td>
                                <td><input type="text" class='static-profile-textbox' name="name" value="<?php echo $_SESSION['userName']; ?>" readonly></td>
                            </tr>
                            <!-- Email -->
                            <tr class="tr-row">
                                <td>Email:</td>
                                <td><input type="email" class='static-profile-textbox' name="email" value="<?php echo $_SESSION['userEmail']; ?>" readonly></td>
                            </tr>
                            <!-- Pets Interested -->
                            <tr class="tr-row">
                                <td>Pets Interested:</td>
                                <td>
                                    <select name="pets_interested" class='profile-dropdown'>
                                        <option value="" disabled <?php echo empty($petsInterested) ? 'selected' : ''; ?>>Select Pets</option>
                                        <option value="Cats" <?php echo $petsInterested == 'cats' ? 'selected' : ''; ?>>Cats</option>
                                        <option value="Dogs" <?php echo $petsInterested == 'dogs' ? 'selected' : ''; ?>>Dogs</option>
                                        <option value="Both" <?php echo $petsInterested == 'both' ? 'selected' : ''; ?>>Both</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- Country -->
                            <tr class="tr-row">
                                <td>Country:</td>
                                <td>
                                    <select name="country" class='profile-dropdown'>
                                        <option value="" disabled <?php echo empty($country) ? 'selected' : ''; ?>>Select Country</option>
                                        <option value="MY" <?php echo $country == 'MY' ? 'selected' : ''; ?>>Malaysia</option>
                                        <option value="JP" <?php echo $country == 'JP' ? 'selected' : ''; ?>>Japan</option>
                                        <option value="THI" <?php echo $country == 'THI' ? 'selected' : ''; ?>>Thailand</option>
                                        <option value="SIN" <?php echo $country == 'SIN' ? 'selected' : ''; ?>>Singapore</option>
                                        <option value="Other" <?php echo $country == 'Other' ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- Pets Owned -->
                            <tr class="tr-row">
                                <td>Pets Owned:</td>
                                <td>
                                    <select name="pets_owned" class='profile-dropdown'>
                                        <option value="" disabled <?php echo empty($petsOwned) ? 'selected' : ''; ?>>Select Number</option>
                                        <option value="0" <?php echo $petsOwned == '0' ? 'selected' : ''; ?>>0</option>
                                        <option value="1" <?php echo $petsOwned == '1' ? 'selected' : ''; ?>>1</option>
                                        <option value="2" <?php echo $petsOwned == '2' ? 'selected' : ''; ?>>2</option>
                                        <option value="3" <?php echo $petsOwned == '3' ? 'selected' : ''; ?>>3</option>
                                        <option value="4" <?php echo $petsOwned == '4' ? 'selected' : ''; ?>>4</option>
                                        <option value="5" <?php echo $petsOwned == '5' ? 'selected' : ''; ?>>5</option>
                                        <option value="6" <?php echo $petsOwned == '6' ? 'selected' : ''; ?>>6</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- About Me -->
                            <tr class="tr-row">
                                <td>About Me:</td>
                                <td><textarea name="about_me" class='profile-textbox' rows="4" style="height: 150px; resize: none;" placeholder="Tell us about yourself..."><?php echo htmlspecialchars($aboutMe); ?></textarea></td>
                            </tr>
                        </table>
                        <button type="submit" name="submit" class="buttondeco">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Purchase List -->
        <h2 style="padding-left: 70px;">Recent Purchases</h2>
        <div class="history-frame" style="text-align: center;">
        <?php
        if ($purchaseRes == true && mysqli_num_rows($purchaseRes) > 0) {
            echo "<table class='table table-striped'>";
            echo "<thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($purchaseRes)) {
                $orderId = $row['orderId'];
                $orderDate = date('F j, Y, g:i a', strtotime($row['orderDate']));
                $totalAmount = $row['totalAmount'];
                $paymentMethod = $row['paymentMethod'];

                echo "<tr class='purchaseHistory'>
                        <td>$orderId</td>
                        <td>$orderDate</td>
                        <td>RM $totalAmount</td>
                        <td>$paymentMethod</td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='alert alert-info'>You have no recent purchases.</div>";
        }
        ?>
    </div>

    <br/><br/>

    <?php include('header/footer.php'); ?>

    <script>
        var daysRemaining = <?php echo $daysRemaining; ?>;
        var countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            if (daysRemaining > 0) {
                countdownElement.textContent = daysRemaining--;
            } else {
                countdownElement.textContent = "Expired";
            }
        }

        // Update the countdown everyday
        setInterval(updateCountdown, 24 * 60 * 60 * 1000);
    </script>
    </body>
</html>
