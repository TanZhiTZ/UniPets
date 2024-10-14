<?php
include('config/constants.php');

$productId = $_GET['product_id'];

$sql = "SELECT * FROM accessories WHERE accessoriesId='$productId'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

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
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNIPETS | Pets Details</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" 
       src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
       <style>
        .image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('img/products/<?php echo $productImg; ?>');
            background-size: cover;
            background-position: center;
            filter: blur(20px);
            z-index: 1;
        }
        </style>
</head>
    <body>
        <!-- Background -->
        <?php include('background.php'); ?>
    
        <!-- Header -->
        <div class="header">
                <?php include('header/header.php'); ?>
        </div>

        <!-- Back Button -->
        <div>
            <a href="products.php"><button class="back-button" onclick="goBack()"><</button></a>
        </div>

        <!-- Product Image -->
        <div class='image-container'>
            <img src='img/products/<?php echo"$productImg";?>' alt='<?php echo"$productName";?>'>
        </div>
        
        <!-- Product Information -->
        <div class="profile-container">
            <div class="profile-left">
                <h1 style="color: darkblue;"><?php echo"$productName";?></h1>
                <br/>
                <hr/>
                <div class="profile-about">
                    <h2 style="margin-left: -10px;">About Product</h2>
                    <p style="margin-top: -20px;"><?php echo $productDescription; ?></p>
                    <br/>
                <br/>
                </div>
            </div>
            <div class="profile-right">
                <div class="profile-call-to-action">
                    <h2 style="color: white; text-align: center;">Cart</h2>
                    <div class="quantity-container">
                        <label for="quantity">Quantity</label>
                        <div class="quantity-input">
                            <button class="quantity-btn" onclick="decrement()">-</button>
                            <input type="text" id="quantity" value="1" readonly>
                            <button class="quantity-btn" onclick="increment(<?php echo $stockQuantity; ?>)">+</button>
                        </div>
                    </div>
                    <div>
                        <button class="cart-btn" onclick="addToCart(<?php echo $accessoriesId; ?>)">Add To Cart</button>
                        <!-- <button class="buy-btn">Buy Now</button> -->
                    </div>
                </div>
            </div>
        </div>
        
        
        <br/><br/>
        <?php include('header/footer.php'); ?>


<script>
    function increment(stockQuantity) {
        let quantity = document.getElementById("quantity");
        let currentQuantity = parseInt(quantity.value);
        if (quantity.value < stockQuantity) {
            quantity.value = currentQuantity + 1;
        }
    }

    function decrement() {
        let quantity = document.getElementById("quantity");
        let currentQuantity = parseInt(quantity.value);
        if (currentQuantity > 1) {
            quantity.value = currentQuantity - 1;
        }
    }

    function addToCart(accessoriesId) {
    let quantity = parseInt(document.getElementById("quantity").value);

    // Log the data being sent
    console.log("Accessories ID:", accessoriesId);
    console.log("Quantity:", quantity);

    // AJAX call to PHP script to check session and add to cart
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "addToCart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = xhr.responseText;
            console.log("Response:", response);
            if (response === "NOT_LOGGED_IN") {
                alert("Please log in to add items to your cart.");
            } else if (response === "SUCCESS") {
                alert(quantity + " item(s) added to your cart.");
            } else {
                alert("Error adding to cart. Please try again.");
            }
        }
    };
    xhr.send("accessoriesId=" + accessoriesId + "&quantity=" + quantity);
}

</script>
    </body>
</html>
