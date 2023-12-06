<?php 
    session_start();
    include '../../model/database.php';
    $username = $_GET['username'];
    $db = new Database();
    $_SESSION['msg'] = 'Đã xoá thành công user: '.$username;
	$_SESSION['status'] = 'success';
    $db->deleteUserByUsername($username);
    header("Location: ../users.php");
?>