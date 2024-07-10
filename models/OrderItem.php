<?php
class OrderItem {
    private $conn;
    private $table = 'order_items';

    // Order item properties
    public $id;
    public $order_id;
    public $dish_id;
    public $quantity;
    public $price;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new order item
    public function create() {
        // SQL query to insert a new order item into the order_items table
        $query = "INSERT INTO " . $this->table . " (order_id, dish_id, quantity, price) VALUES (:order_id, :dish_id, :quantity, :price)";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind parameters to the query
        $stmt->bindParam(':order_id', $this->order_id);
        $stmt->bindParam(':dish_id', $this->dish_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':price', $this->price);

        // Execute the query and return the result
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all order items by order ID
    public function readByOrderId($order_id) {
        // SQL query to select all order items for a specific order
        $query = "SELECT * FROM " . $this->table . " WHERE order_id = :order_id";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);

        // Execute the query
        $stmt->execute();

        return $stmt;
    }
}
?>
