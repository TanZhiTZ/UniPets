<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
    private $cart_table = "user_cart"; 
    private $library_table = "user_library";
 
    public $user_id;
    public $book_id;
    public $book_title;
    public $book_description;
    public $book_img_name;
    public $book_price;
    public $id;
    public $title;
    public $author;
    public $description;
    public $img_name;
    public $price;
    public $category_id;
    public $category_name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function read(){
    
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.title, p.author, p.description, p.img_name, p.price, p.category_id
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    function read_cart(){
    
        // select all query
        $query = "SELECT
                    book_id, book_title, book_description, book_img_name, book_price
                FROM
                    " . $this->cart_table . " 
                WHERE
                    user_id = $this->user_id 
                ORDER BY
                    book_id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    function read_library(){
    
        // select all query
        $query = "SELECT
                    user_id, book_id, book_title, book_description, book_img_name, book_price
                FROM
                    " . $this->library_table . " 
                WHERE
                    user_id = $this->user_id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    //read random products
    function readRandom(){
    
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.title, p.author, p.description, p.img_name, p.price, p.category_id
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    RAND () LIMIT 3";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    
    // create product
    function create(){

        $read_query = "SELECT
                     user_id, book_id
                FROM
                    " . $this->cart_table . " 
                WHERE
                    user_id = $this->user_id AND book_id = $this->book_id";

        $no_duplicate_query = "SELECT
                        user_id, book_id
                FROM
                    " . $this->library_table . " 
                WHERE
                    user_id = $this->user_id AND book_id = $this->book_id";

        // prepare query statement
        $stmt = $this->conn->prepare($read_query);
    
        // execute query
        $stmt->execute();
        $num = $stmt->rowCount(); // getting the number of rows

        // prepare query statement
        $stmt_no_duplicate = $this->conn->prepare($no_duplicate_query);
    
        // execute query
        $stmt_no_duplicate->execute();
        $num_no_duplicate = $stmt_no_duplicate->rowCount(); // getting the number of rows

        if ($num_no_duplicate==0) {
            if ($num==0) {
                // query to insert record   //******wonders if i should change the table name */
                $query = "INSERT INTO
                            " . $this->cart_table . "
                        SET
                            user_id=:user_id, book_id=:book_id, book_title=:book_title, book_description=:book_description, book_img_name=:book_img_name, book_price=:book_price";
                
                // prepare query
                $stmt = $this->conn->prepare($query);
            
                // sanitize
                $this->user_id=htmlspecialchars(strip_tags($this->user_id));
                $this->id=htmlspecialchars(strip_tags($this->book_id));
                $this->title=htmlspecialchars(strip_tags($this->book_title));
                $this->description=htmlspecialchars(strip_tags($this->book_description));
                $this->img_name=htmlspecialchars(strip_tags($this->book_img_name));
                $this->price=htmlspecialchars(strip_tags($this->book_price));
            
                // bind values
                $stmt->bindParam(":user_id", $this->user_id);
                $stmt->bindParam(":book_id", $this->book_id);
                $stmt->bindParam(":book_title", $this->book_title);
                $stmt->bindParam(":book_description", $this->book_description);
                $stmt->bindParam(":book_img_name", $this->book_img_name);
                $stmt->bindParam(":book_price", $this->book_price);
                
                // execute query
                if($stmt->execute()){
                    return true;
                }
            }
        }
    return false;

    }

    // create library product
    function createLibrary(){

        $read_query = "SELECT
                     user_id, book_id
                FROM
                    " . $this->library_table . " 
                WHERE
                    user_id = $this->user_id AND book_id = $this->book_id";

        // prepare query statement
        $stmt = $this->conn->prepare($read_query);
    
        // execute query
        $stmt->execute();
        $num = $stmt->rowCount(); // getting the number of rows
    
        if ($num==0) {
            // query to insert record   //******wonders if i should change the table name */
            $query = "INSERT INTO
                        " . $this->library_table . "
                    SET
                        user_id=:user_id, book_id=:book_id, book_title=:book_title, book_description=:book_description, book_img_name=:book_img_name, book_price=:book_price";
            
            // prepare query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->id=htmlspecialchars(strip_tags($this->book_id));
            $this->title=htmlspecialchars(strip_tags($this->book_title));
            $this->description=htmlspecialchars(strip_tags($this->book_description));
            $this->img_name=htmlspecialchars(strip_tags($this->book_img_name));
            $this->price=htmlspecialchars(strip_tags($this->book_price));
        
            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":book_id", $this->book_id);
            $stmt->bindParam(":book_title", $this->book_title);
            $stmt->bindParam(":book_description", $this->book_description);
            $stmt->bindParam(":book_img_name", $this->book_img_name);
            $stmt->bindParam(":book_price", $this->book_price);
            
            // execute query
            if($stmt->execute()){
                return true;
            }
        }
    return false;

    }

    // used when filling up the update product form
    function readOne(){
 
    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.title, p.author, p.description, p.img_name, p.price, p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($row['title'] != NULL) {
        // set values to object properties
        $this->title = $row['title'];
        $this->author = $row['author'];
        $this->description = $row['description'];
        $this->img_name = $row['img_name'];
        $this->price = $row['price'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    }

    function readCategory(){
 
        // query to read single record
        $query = "SELECT
                c.name as category_name, p.id, p.title, p.author, p.description, p.img_name, p.price, p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.category_id = ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->category_id);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
        }

    // update the product
    function update_password(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id = :category_id
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
    }

    // delete the product
    function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->cart_table . " WHERE user_id = ? AND book_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->book_id=htmlspecialchars(strip_tags($this->book_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->user_id);
    $stmt->bindParam(2, $this->book_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
    }

    // search products
    function search($keywords){
 
    // select all query
    $query = "SELECT
                c.name as category_name, p.id, p.title, p.author, p.description, p.img_name, p.price, p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.title LIKE ? OR p.description LIKE ? OR p.author LIKE ?
            ORDER BY
                p.id DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
    }

    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
    }

    // used for paging products
    public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
    }
}
?>