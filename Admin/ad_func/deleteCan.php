<?php 
    session_start();
    include '../../model/database.php';
    $can_id = $_GET['can_id'];
    $db = new Database();
    $_SESSION['msg'] = 'Đã xoá thành công candidates có id : '.$can_id;
	$_SESSION['status'] = 'success';
    $db->deleteCanById($can_id);
    header("Location: ../candi.php");
?>