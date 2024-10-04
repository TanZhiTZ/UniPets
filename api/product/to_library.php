<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/product.php';
 
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : die(); //use this for the user_id

$product->user_id = $user_id;

$stmt = $product->read_cart();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $product_item=array(
            "book_id" => $book_id,
            "book_title" => $book_title,
            "book_description" => html_entity_decode($book_description),
            "book_img_name" => $book_img_name,
            "book_price" => $book_price,
        );
        if(
            !empty($book_id) &&
            !empty($book_title) &&
            !empty($book_description) &&
            !empty($book_img_name) &&
            !empty($book_price)
        ){
            //******need to get information and then send in here before can use */
            $product->book_id = $book_id;
            $product->book_title = $book_title;
            $product->book_description = $book_description;
            $product->book_img_name = $book_img_name;
            $product->book_price = $book_price;

            $product->createLibrary();
            $product->delete();
        }
    }
    header("Location: http://localhost/e_booker/checkout.php",  true,  301 );  exit;
    // set response code - 200 OK
    http_response_code(200);
}
?>