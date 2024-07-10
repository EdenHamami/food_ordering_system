<?php
include_once '../config/database.php';
include_once '../controllers/DishController.php';

$dishController = new DishController();
$dishController->create();
?>
