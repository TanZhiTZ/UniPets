<?php

include('config/constants.php');

$limit = 6;

// default page = 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $limit;

// Total number of products
$total_pets_sql = "SELECT COUNT(*) as total FROM accessories WHERE category='Dogs'";
$total_pets_result = mysqli_query($conn, $total_pets_sql);
$total_pets_row = mysqli_fetch_assoc($total_pets_result);
$total_pets = $total_pets_row['total'];

// Total number of pages
$total_pages = ceil($total_pets / $limit);

$sql = "SELECT * FROM accessories WHERE category='Dogs' LIMIT $limit OFFSET $offset";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>UNIPETS | Accessories</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" 
       src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <!-- Background -->
    <?php include('background.php'); ?>
    
    <!-- Header -->
    <div class="header">
            <?php include('header/header.php'); ?>
    </div>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="products.php"><p class="glow-font">All Items</p></a></li>
                <li><a href="cat-products.php"><p class="glow-font">Cat Accessories</p></a></li>
                <li style="background-color: #5291f7; border-radius: 20px;" class="glow-button"><a href="dogList.php"><p>Dog Accessories</p></a></li>
            </ul>
        </div>
        <div class="product-grid">
            <?php
                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $accessoriesId = $row['accessoriesId'];
                        $productImg = $row['productImg'];
                        $productName = $row['productName'];
                        $productDescription = $row['productDescription'];
                        $price = $row['price'];
                        $stockQuantity = $row['stockQuantity'];

                        echo "<div class='product-card' onclick=";
                        echo '"window.location.href=';
                        echo "'product-description.php?product_id=$accessoriesId';";
                        echo '">';
                        echo "
                            <div class='image-wrapper'>
                                    <img src='img/products/$productImg' alt='$productName'>
                                </div>
                                <div class='product-title'><p>$productName</p></div>
                                <div class='product-price'><p style='color: #73d3ff;'>RM $price</p></div>
                            </div>
                        ";
                    }
                }
            ?>
        </div>
    </div>

    <!-- Pagination -->
    <ul class="pagination">
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?php if($i == $page) echo 'active'; ?>">
                <a href="dog-products.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>

    <br/><br/>
    <?php include('header/footer.php'); ?>
</body>
</html>
