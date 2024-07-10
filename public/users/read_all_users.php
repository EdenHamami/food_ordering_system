<?php
include_once '../config/database.php';
include_once '../controllers/UserController.php';

$userController = new UserController();
$userController->readAllUsers();
?>
