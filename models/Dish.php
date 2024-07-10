<?php
class Dish {
    private $conn;
    private $table = 'dishes';

    // Dish properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new dish
    public function create() {
        // SQL query to insert a new dish into the dishes table
        $query = "INSERT INTO " . $this->table . " (name, description, price, category) VALUES (:name, :description, :price, :category)";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind parameters to the query
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);

        // Execute the query and return the result
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read dishes
    public function read() {
        // SQL query to select all dishes
        $query = "SELECT * FROM " . $this->table;
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Execute the query
        $stmt->execute();

        return $stmt;
    }

    // Read single dish by ID
    public function readSingle() {
        // SQL query to select a dish by ID
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind ID to the query
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        $stmt->execute();

        // Fetch the dish data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set dish properties
        if($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->category = $row['category'];
        } else {
            $this->name = null;
            $this->description = null;
            $this->price = null;
            $this->category = null;
        }
    }

    // Update dish
    public function update() {
        // SQL query to update a dish
        $query = "UPDATE " . $this->table . " SET name = :name, description = :description, price = :price, category = :category WHERE id = :id";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind parameters to the query
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        // Execute the query and return the result
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete dish
    public function delete() {
        // SQL query to delete a dish
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind ID to the query
        $stmt->bindParam(':id', $this->id);

        // Execute the query and return the result
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
