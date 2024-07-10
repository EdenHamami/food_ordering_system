<?php
include_once '../config/database.php';
include_once '../controllers/AuthController.php';

$authController = new AuthController();
$authController->register();
?>
