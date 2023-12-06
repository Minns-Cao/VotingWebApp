<?php
header('Content-Type: application/json');
include '../../model/database.php';
$email = $_GET['email'];
$db = new Database();
$user = $db->getUserByEmail($email);
echo json_encode($user);

