<?php
session_start();
include '../../model/database.php';
$username = $_POST['username'];
$usernameOld = $_POST['usernameOld'];
$role = $_POST['role'];
$password = $_POST['password'];
$email = $_POST['email'];
$db = new Database();
//valid
$db->updUser($username, $role, $email, $password,$usernameOld);
$_SESSION['msg'] = 'Cập nhật thông tin khách hàng thành công';
$_SESSION['status'] = 'success';

header("Location: ../users.php");
