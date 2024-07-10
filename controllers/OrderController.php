<?php
include_once '../config/database.php';
include_once '../models/Order.php';
include_once '../models/OrderItem.php';

class OrderController {
    private $db;
    private $order;
    private $orderItem;

    public function __construct() {
        // Create a database connection
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Create a new Order object
        $this->order = new Order($this->db);
        $this->orderItem = new OrderItem($this->db);
    }

    // Function to handle creating a new order
    public function create() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set order properties from POST data
            $this->order->user_id = $_POST['user_id'];
            $this->order->total_price = $_POST['total_price'];

            // Attempt to create the order
            if ($this->order->create()) {
                // Create order items
                $order_items = json_decode($_POST['order_items'], true);
                foreach ($order_items as $item) {
                    $this->orderItem->order_id = $this->order->id;
                    $this->orderItem->dish_id = $item['dish_id'];
                    $this->orderItem->quantity = $item['quantity'];
                    $this->orderItem->price = $item['price'];
                    $this->orderItem->create();
                }

                http_response_code(201); // Set HTTP status code to 201 Created
                echo json_encode(['message' => 'Order created successfully.']);
            } else {
                http_response_code(400); // Set HTTP status code to 400 Bad Request
                echo json_encode(['message' => 'Order creation failed.']);
            }
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle reading all orders
    public function read() {
        // Check if the request method is GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Get orders from the model
            $stmt = $this->order->read();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return orders as JSON
            http_response_code(200); // Set HTTP status code to 200 OK
            echo json_encode($orders);
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }

    // Function to handle reading order items by order ID
    public function readOrderItems($order_id) {
        // Check if the request method is GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Get order items from the model
            $stmt = $this->orderItem->readByOrderId($order_id);
            $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return order items as JSON
            http_response_code(200); // Set HTTP status code to 200 OK
            echo json_encode($order_items);
        } else {
            http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
            echo json_encode(['message' => 'Invalid request method.']);
        }
    }
}
?>
