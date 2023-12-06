<?php 
error_reporting(E_ERROR);
ini_set('display_errors', 1);
include '../model/database.php';
session_start();
if (!$_SESSION['userLogin']) {
    $_SESSION['msg'] = 'Bạn cần đăng nhập để bình chọn';
    $_SESSION['status'] = 'warning';
    header("Location: ../../account.php");
    exit;
}

$can_id = $_GET['canid'];
$userLogin = $_SESSION['userLogin'];
$db = new Database();
$isVoted = $db->isVoted($userLogin['id'], $can_id);

if ($isVoted) {
    $_SESSION['msg'] = 'Bạn đã bình chọn cho thí sinh này rồi';
    $_SESSION['status'] = 'warning';
} else {
    $db->addVote($userLogin['id'], $can_id);
    $_SESSION['msg'] = 'Đã bình chọn thành công';
    $_SESSION['status'] = 'success';
}

header(sprintf("Location: ../../candi.php?canid=%s", $can_id));
?>

