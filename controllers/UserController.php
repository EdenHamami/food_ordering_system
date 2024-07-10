<?php
include_once '../config/database.php';
include_once '../models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        // Create a database connection
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Create a new User object
        $this->user = new User($this->db);
    }

    // Function to handle reading all users
    public function readAllUsers() {
        // Check if the request method is GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Get users from the model
            $stmt = $this->user->readAll();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return users as JSON
            http_response_code(200); // Set HTTP status code to 200 OK
            echo json_encode($users);
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }
}
?>
