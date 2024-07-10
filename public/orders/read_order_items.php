<?php
include_once '../config/database.php';
include_once '../controllers/OrderController.php';

$orderController = new OrderController();
$order_id = $_GET['order_id'];
$orderController->readOrderItems($order_id);
?>
