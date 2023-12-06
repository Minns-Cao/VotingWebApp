<?php 
    session_start();
    unset($_SESSION['userLogin']);
    $_SESSION['msg'] = 'Đã đăng xuất, truy cập bằng tài khoản khách';
	$_SESSION['status'] = 'warning';
    header("Location: ../index.php");
