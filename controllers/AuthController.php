<?php
include_once '../config/database.php';
include_once '../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        // Create a database connection
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Create a new User object
        $this->user = new User($this->db);
    }

    // Function to handle user registration
    public function register() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set user properties from POST data
            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];
            $this->user->role = $_POST['role'];
            $this->user->email = $_POST['email'];

            // Attempt to register the user
            if ($this->user->register()) {
                http_response_code(201); // Set HTTP status code to 201 Created
                echo json_encode(['message' => 'User registered successfully.']);
            } else {
                http_response_code(400); // Set HTTP status code to 400 Bad Request
                echo json_encode(['message' => 'User registration failed. Username might already exist.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle user login
    public function login() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set user properties from POST data
            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];

            // Attempt to login the user
            $user = $this->user->login();
            if ($user) {
                http_response_code(200); // Set HTTP status code to 200 OK
                echo json_encode(['message' => 'Login successful.', 'user' => $user]);
            } else {
                http_response_code(401); // Set HTTP status code to 401 Unauthorized
                echo json_encode(['message' => 'Login failed. Invalid username or password.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }
}
?>
