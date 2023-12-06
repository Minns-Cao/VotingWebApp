<?php
session_start();
include '../../model/database.php';
$can_id = $_POST['can_id'];
$can_name = $_POST['can_name'];
$can_desc = $_POST['can_desc'];
$can_adr = $_POST['can_adr'];
$can_id_old =$_POST['can_id_old'];
$can_avt = $_FILES['can_avt']['name'];
$generated_can_avt = time() . '-' . $can_avt;
$file_tmp_name = $_FILES['can_avt']['tmp_name'];
$destination_path = $_SERVER['DOCUMENT_ROOT'] . "/Voting/assest/uploads/" . $generated_can_avt;
$db = new Database();

if ($can_id == $can_id_old) {
    $db->updCan($can_id, $can_name, $can_desc, $can_adr, $generated_can_avt);
    move_uploaded_file($file_tmp_name, $destination_path);
    $_SESSION['msg'] = 'Cập nhật thông tin thí sinh thành công';
    $_SESSION['status'] = 'success';
} else {
    $_SESSION['msg'] = 'Không thể thay đổi ID của thí sinh';
    $_SESSION['status'] = 'danger';
}



header("Location: ../candi.php");
