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
 
// get posted data
// $data = file_get_contents("php://input");
// print_r($data);

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : die(); //use this for the user_id
$book_id = isset($_POST['id']) ? $_POST['id'] : die();
$book_title = isset($_POST['title']) ? $_POST['title'] : die();
$book_description = isset($_POST['description']) ? $_POST['description'] : die();
$book_img_name = isset($_POST['img_name']) ? $_POST['img_name'] : die();
$book_price = isset($_POST['price']) ? $_POST['price'] : die();

// make sure data is not empty
if(
    !empty($user_id) &&
    !empty($book_id) &&
    !empty($book_title) &&
    !empty($book_description) &&
    !empty($book_img_name) &&
    !empty($book_price)
){
    // set product property values
    $product->user_id = $user_id;
    $product->book_id = $book_id;
    $product->book_title = $book_title;
    $product->book_description = $book_description;
    $product->book_img_name = $book_img_name;
    $product->book_price = $book_price;
 
    // create the product
    if($product->create()){
        header("Location: http://localhost/e_booker/index.php#categories",  true,  301 );  exit;
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
 
    // if unable to create the product, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}
 
// tell the user data is incomplete
else{
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>