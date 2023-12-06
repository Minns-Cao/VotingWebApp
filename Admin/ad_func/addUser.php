<?php 
    session_start();
    include '../../model/database.php';
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $db = new Database();
    //valid
    $isDupUsername = $db->isDupUsername($username);
	$isDupEmail = $db->isDupEmail($email);
    if ($isDupUsername) {
		$_SESSION['msg'] = 'Username đã tồn tại, vui lòng thay đổi';
		$_SESSION['status'] = 'warning';
	} else if ($isDupEmail) {
		$_SESSION['msg'] = 'Email đã tồn tại, hãy chuyển đến trang đăng nhập';
		$_SESSION['status'] = 'warning';
	} else {
        $db->addUserByAdmin($username, $role, $email, $password);
        $_SESSION['msg'] = 'Tạo tài khoản mới thành công';
		$_SESSION['status'] = 'success';
    }
    header("Location: ../users.php");
?>