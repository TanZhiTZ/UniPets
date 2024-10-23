<?php
include '../config/constants.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    if ($role != "admin") {
        header('location:../index.php');
    }
} else {
    header('location:../index.php');
}

$accessoriesSQL = "SELECT * FROM accessories";
$accessoriesResult = $conn->query($accessoriesSQL);
$accessoriesResult2 = $conn->query($accessoriesSQL);

$restockSQL = "SELECT * FROM restock";
$result = $conn->query($restockSQL);


// Function to handle adding a new accessory
if (isset($_POST['addAccessory'])) {
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];

    // Image upload handling
    $targetDir = "../img/products/";
    $fileName = basename($_FILES["img"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    // Check if the uploaded file is an image
    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)) {
            // Insert new pet into database
            $addAccessorySQL = "INSERT INTO accessories (productName, category, productImg, price, stockQuantity) 
                    VALUES ('$productName', '$category', '$fileName', '$price', '$stockQuantity')";
            if ($conn->query($addAccessorySQL) === TRUE) {
                echo "Accessory added successfully!";
                header("Refresh:0");
            } else {
                echo "Error adding accessory: " . $conn->error;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}

// Function to handle deleting accessories
if (isset($_POST['deleteAccessory'])) {
    $accessoriesId = $_POST['accessoriesId'];

    $deleteAccessorySQL = "DELETE FROM accessories WHERE accessoriesId=$accessoriesId";
    if ($conn->query($deleteAccessorySQL) === TRUE) {
        echo "Accessory deleted successfully!";
        header("Refresh:0");
    } else {
        echo "Error deleting accessory: " . $conn->error;
    }
}

// Function to handle editing accessories
if (isset($_POST['editAccessory'])) {
    $accessoriesId = $_POST['accessoriesId'];
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];

    $updateAccessorySQL = "UPDATE accessories 
                           SET productName='$productName', category='$category', price='$price', stockQuantity='$stockQuantity' 
                           WHERE accessoriesId=$accessoriesId";
    if ($conn->query($updateAccessorySQL) === TRUE) {
        echo "Accessory updated successfully!";
        header("Refresh:0");
    } else {
        echo "Error updating accessory: " . $conn->error;
    }
}

// Function to handle restock and update stockQuantity in accessories table
if (isset($_POST['restockItem'])) {
    $accessoriesId = $_POST['accessoriesId'];
    $supplier = $_POST['supplier'];
    $quantity = $_POST['quantity'];

    $getStockSQL = "SELECT stockQuantity FROM accessories WHERE accessoriesId = $accessoriesId";
    $stockResult = $conn->query($getStockSQL);
    if ($stockResult->num_rows > 0) {
        $row = $stockResult->fetch_assoc();
        $newStockQuantity = $row['stockQuantity'] + $quantity;

        // Update stockQuantity
        $updateStockSQL = "UPDATE accessories SET stockQuantity = $newStockQuantity WHERE accessoriesId = $accessoriesId";
        if ($conn->query($updateStockSQL) === TRUE) {
            $productName = $_POST['productName'];
            $insertRestockSQL = "INSERT INTO restock (accessoriesId, productName, supplier, quantity) 
                                VALUES ('$accessoriesId', '$productName', '$supplier', $quantity)";
            if ($conn->query($insertRestockSQL) === TRUE) {
                echo "Restock successful and stock updated!";
                header("Refresh:0");
            } else {
                echo "Error inserting into restock table: " . $conn->error;
            }
        } else {
            echo "Error updating stock quantity: " . $conn->error;
        }
    } else {
        echo "Accessory not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inventory</title>
    <link rel="stylesheet" href="css/adminStyle.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="main-content">
        <h2 style="text-align: center;">Restock an Item</h2>
            <form method="POST">
                <!-- Select accessory to restock -->
                <label for="accessoriesId">Select Accessory:</label>
                <select id="accessoriesId" name="accessoriesId" onchange="updateProductName()" required>
                    <option value="" disabled selected>Select an accessory</option>
                    <?php
                    if ($accessoriesResult->num_rows > 0) {
                        while ($row = $accessoriesResult->fetch_assoc()) {
                            echo "<option value='" . $row['accessoriesId'] . "' data-productname='" . $row['productName'] . "'>" 
                                 . $row['productName'] . " (Current Stock: " . $row['stockQuantity'] . ")</option>";
                        }
                    }
                    ?>
                </select><br><br>

                <!-- Product Name (auto-filled based on accessory selected) -->
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" readonly><br><br>

                <!-- Supplier -->
                <label for="supplier">Supplier:</label>
                <input type="text" id="supplier" name="supplier" required><br><br>

                <!-- Quantity -->
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required><br><br>

                <input type="submit" name="restockItem" value="Restock Item">
            </form><br/></br>

            <!-- Add New Product Form -->
            <h2 style="text-align: center;">Add New Product</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required><br><br>

                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="Cat">Cat</option>
                    <option value="Dog">Dog</option>
                </select><br><br>

                <label for="img">Product Image:</label>
                <input type="file" id="img" name="img" required><br><br>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required><br><br>

                <label for="stockQuantity">Stock Quantity:</label>
                <input type="number" id="stockQuantity" name="stockQuantity" min="1" required><br><br>

                <input type="submit" name="addAccessory" value="Add Accessory">
            </form><br/><br/>

            <!-- Accessories List (Editable) -->
            <h3>Manage Accessories</h3>
            <table>
                <thead>
                    <tr>
                        <th>Accessory ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($accessoriesResult2->num_rows > 0) {
                        while ($row = $accessoriesResult2->fetch_assoc()) {
                            echo "<tr>";
                            echo "<form method='POST'>";

                            // Accessories ID (hidden)
                            echo "<td><input type='hidden' name='accessoriesId' value='" . $row['accessoriesId'] . "'>" . $row['accessoriesId'] . "</td>";

                            // Product Name (editable text input)
                            echo "<td><input type='text' name='productName' value='" . $row['productName'] . "'></td>";

                            // Category (dropdown with Cats and Dogs)
                            echo "<td>";
                            echo "<select name='category'>";

                            // Define the allowed categories
                            $categories = ['Cats', 'Dogs'];

                            // Loop through the categories and set the selected one based on the current row data
                            foreach ($categories as $category) {
                                $selected = ($row['category'] == $category) ? "selected" : "";
                                echo "<option value='$category' $selected>$category</option>";
                            }

                            echo "</select>";
                            echo "</td>";

                            // Product Image (display only, not editable)
                            echo "<td><img src='../img/products/" . $row['productImg'] . "' alt='Product Image' width='50'></td>";

                            // Price (editable)
                            echo "<td><input type='number' name='price' value='" . $row['price'] . "' step='0.01'></td>";

                            // Stock Quantity (editable)
                            echo "<td><input type='number' name='stockQuantity' value='" . $row['stockQuantity'] . "'></td>";

                            // Action buttons (Edit, Delete)
                            echo "<td>
                                    <input type='submit' name='editAccessory' value='Edit'>
                                    <input type='submit' name='deleteAccessory' value='Delete' onclick=\"return confirm('Are you sure you want to delete this accessory?');\">
                                </td>";

                            echo "</form>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No accessories found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- List of restock -->
            <h2>Inventory Restock</h2>
            <table>
                <thead>
                    <tr>
                        <th>Restock ID</th>
                        <th>Accessories ID</th>
                        <th>Product Name</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Date Restock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr style='text-align: center;'>";
                            echo "<td>" . $row['restockId'] . "</td>";
                            echo "<td>" . ($row['accessoriesId'] ?? 'N/A') . "</td>";
                            echo "<td style='width: 30%; white-space: nowrap;'>" . $row['productName'] . "</td>";
                            echo "<td>" . $row['supplier'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['dateRestock'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No restock records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
        // Update the product name field when an accessory is selected
        function updateProductName() {
            var select = document.getElementById("accessoriesId");
            var productName = select.options[select.selectedIndex].getAttribute('data-productname');
            document.getElementById("productName").value = productName;
        }
        </script>
    </div>
</body>
</html>
