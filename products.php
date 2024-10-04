<!DOCTYPE html>
<html lang="en">
<head>
<title>UNIPETS | Pets List</title>
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
    <!-- Header -->
    <div class="header">
            <?php include('header/header.php'); ?>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="petList.php">All Items</a></li>
                <li><a href="catList.php">Cat Accessories</a></li>
                <li><a href="dogList.php">Dog Accessories</a></li>
            </ul>
        </div>

        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
            <div class="image-wrapper">
                    <img src="img/cats/cat1.jpg" alt="Cat" class="product-img">
                </div>
                <div class="product-title">Cat Food</div>
                <div class="product-price">$30.00</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <!-- Product 2 -->
            <div class="product-card">
                <div class="image-wrapper">
                    <img src="img/cats/cat1.jpg" alt="Cat" class="product-img">
                </div>
                <div class="product-title">Dog Food</div>
                <div class="product-price">$120.00</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <!-- Product 3 -->
            <div class="product-card">
            <div class="image-wrapper">
                    <img src="img/cats/cat1.jpg" alt="Cat" class="product-img">
                </div>
                <div class="product-title">Things</div>
                <div class="product-price">$24.99</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
    </div>
</body>
</html>
