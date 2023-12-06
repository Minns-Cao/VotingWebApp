<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);
include './components/header.php';
include './model/database.php';
session_start();
$can_id = $_GET['canid'];
$userLogin = $_SESSION['userLogin'];
$db = new Database();
$can = $db->getCanById($can_id);
?>

<div class="container">
<h1>Id: <?php echo $can['can_id']?></h1>
<h1>Name: <?php echo $can['can_name']?></h1>
<h1>Description: <?php echo $can['can_desc']?></h1>
<?php echo "<a href='./components/addvote.php/?canid=".$can_id."' class='button'>Bình chọn</a>" ?>
</div>




<?php include './components/notication.php' ?>
