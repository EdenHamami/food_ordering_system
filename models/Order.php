<?php
class Order {
    private $conn;
    private $table = 'orders';

    // Order properties
    public $id;
    public $user_id;
    public $total_price;
    public $order_date;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new order
    public function create() {
        // SQL query to insert a new order into the orders table
        $query = "INSERT INTO " . $this->table . " (user_id, total_price) VALUES (:user_id, :total_price)";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind parameters to the query
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':total_price', $this->total_price);

        // Execute the query and return the result
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Read all orders
    public function read() {
        // SQL query to select all orders
        $query = "SELECT * FROM " . $this->table;
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Execute the query
        $stmt->execute();

        return $stmt;
    }
}
?>
