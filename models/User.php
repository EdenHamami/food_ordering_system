<?php
class User {
    private $conn;
    private $table = 'Users';

    // User properties
    public $id;
    public $username;
    public $password;
    public $role;
    public $email;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register() {
        // SQL query to insert new user into the Users table
        $query = "INSERT INTO " . $this->table . " (username, password, role, email) VALUES (:username, :password, :role, :email)";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Hash the password
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);

        // Bind parameters to the query
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashed_password); // Use the hashed password variable
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':email', $this->email);

        // Execute the query and return the result
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // User login
    public function login() {
        // SQL query to select user by username
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);

        // Execute the query
        $stmt->execute();

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>
