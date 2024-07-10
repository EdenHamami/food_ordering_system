<?php
include_once '../config/database.php';
include_once '../models/Dish.php';

class DishController {
    private $db;
    private $dish;

    public function __construct() {
        // Create a database connection
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Create a new Dish object
        $this->dish = new Dish($this->db);
    }

    // Function to handle creating a new dish
    public function create() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set dish properties from POST data
            $this->dish->name = $_POST['name'];
            $this->dish->description = $_POST['description'];
            $this->dish->price = $_POST['price'];
            $this->dish->category = $_POST['category'];

            // Attempt to create the dish
            if ($this->dish->create()) {
                http_response_code(201); // Set HTTP status code to 201 Created
                echo json_encode(['message' => 'Dish created successfully.']);
            } else {
                http_response_code(400); // Set HTTP status code to 400 Bad Request
                echo json_encode(['message' => 'Dish creation failed.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle reading all dishes
    public function read() {
        // Check if the request method is GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Get dishes from the model
            $stmt = $this->dish->read();
            $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return dishes as JSON
            http_response_code(200); // Set HTTP status code to 200 OK
            echo json_encode($dishes);
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle reading a single dish by ID
    public function readSingle($id) {
        // Check if the request method is GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Set dish ID
            $this->dish->id = $id;

            // Get the dish from the model
            $this->dish->readSingle();
            if ($this->dish->name != null) {
                // Create array
                $dish_arr = array(
                    "id" => $this->dish->id,
                    "name" => $this->dish->name,
                    "description" => $this->dish->description,
                    "price" => $this->dish->price,
                    "category" => $this->dish->category
                );

                // Return dish as JSON
                http_response_code(200); // Set HTTP status code to 200 OK
                echo json_encode($dish_arr);
            } else {
                http_response_code(404); // Set HTTP status code to 404 Not Found
                echo json_encode(['message' => 'Dish not found.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle updating a dish
    public function update() {
        // Check if the request method is PUT
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            // Parse the incoming data
            parse_str(file_get_contents("php://input"), $put_vars);

            // Set dish properties from PUT data
            $this->dish->id = $put_vars['id'];
            $this->dish->name = $put_vars['name'];
            $this->dish->description = $put_vars['description'];
            $this->dish->price = $put_vars['price'];
            $this->dish->category = $put_vars['category'];

            // Attempt to update the dish
            if ($this->dish->update()) {
                http_response_code(200); // Set HTTP status code to 200 OK
                echo json_encode(['message' => 'Dish updated successfully.']);
            } else {
                http_response_code(400); // Set HTTP status code to 400 Bad Request
                echo json_encode(['message' => 'Dish update failed.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle deleting a dish
    public function delete() {
        // Check if the request method is DELETE
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Parse the incoming data
            parse_str(file_get_contents("php://input"), $delete_vars);

            // Set dish ID from DELETE data
            $this->dish->id = $delete_vars['id'];

            // Attempt to delete the dish
            if ($this->dish->delete()) {
                http_response_code(200); // Set HTTP status code to 200 OK
                echo json_encode(['message' => 'Dish deleted successfully.']);
            } else {
                http_response_code(400); // Set HTTP status code to 400 Bad Request
                echo json_encode(['message' => 'Dish deletion failed.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }
}
?>
