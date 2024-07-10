<?php
include_once '../config/database.php';
include_once '../controllers/OrderController.php';

$orderController = new OrderController();
$orderController->read();
?>
