<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// get product id
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : die(); //use this for the user_id
$book_id = isset($_POST['book_id']) ? $_POST['book_id'] : die(); //use this for the user_id
$product->user_id = $user_id;
$product->book_id = $book_id;
 
// set product id to be deleted
//$product->id = $data->id;
 
// delete the product
if($product->delete()){

    $stmt = $product->read_cart();
    $num = $stmt->rowCount();

    if($num>0){
        header("Location: http://localhost/e_booker/cart.php",  true,  301 );  exit;
    }else {
        header("Location: http://localhost/e_booker/index.php",  true,  301 );  exit;
    }

    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Product was deleted."));
}
 
// if unable to delete the product
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete product."));
}
?>