<?php
session_start();
include '../../model/database.php';
$can_id = $_POST['can_id'];
$can_name = $_POST['can_name'];
$can_desc = $_POST['can_desc'];
$can_adr = $_POST['can_adr'];
$db = new Database();
$can_avt = $_FILES['can_avt']['name'];
$generated_can_avt = time() . '-' . $can_avt;
$file_tmp_name = $_FILES['can_avt']['tmp_name'];
$destination_path = $_SERVER['DOCUMENT_ROOT'] . "/Voting/assest/uploads/" . $generated_can_avt;
$isDupCanId = $db->isDupCanId($can_id);

if ($isDupCanId) {
    $_SESSION['msg'] = 'ID đã tồn tại, vui lòng thay đổi';
    $_SESSION['status'] = 'warning';
} else {
    $db->addCanByAdmin($can_id, $can_name, $can_desc, $can_adr, $generated_can_avt);
    move_uploaded_file($file_tmp_name, $destination_path);
    $_SESSION['msg'] = 'Thêm thí sinh mới thành công';
    $_SESSION['status'] = 'success';
}

header("Location: ../candi.php");
