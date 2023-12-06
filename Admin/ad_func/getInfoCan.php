<?php
header('Content-Type: application/json');
include '../../model/database.php';
$can_id = $_GET['can_id'];
$db = new Database();
$can = $db->getCanById($can_id);
echo json_encode($can);