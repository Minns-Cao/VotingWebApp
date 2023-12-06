<?php
include './components/header.php';
include './model/database.php';
include './model/user.php';
session_start();
$userLogin = $_SESSION['userLogin'];
$db = new Database();
$cans = $db->getCansRank();
?>

<!-- body -->
<section class="voting">
  <div class="container">
    <h1 class="title text-center pt-5">Bảng Xếp Hạng</h1>
    <form id="searchElm" class="w-100 me-3 pt-5" role="search">
      <!-- <input type="search" class="form-control search" placeholder="Search..." aria-label="Search"> -->
    </form>
    <!-- Candidates -->
    <div id="candidates">
      <div class="row gap-3 candidatesList">
        <?php 
        foreach ($cans as $key => $can) {
          echo "<a class='candidatesCard col-xl-3' href='./candi.php?canid=".$can['can_id']."'>";
          echo "<div class='candidatesCard_thumb'>";
          echo "<img src='./assest/uploads/".$can['can_avt']."' alt='' class='img'>";
          echo "<div class='candidatesCard_points'>".$can['votes']." votes</div>";
          echo "</div>";
          echo "<div class='candidatesCard_name'>".$can['can_name']."</div>";
          echo "<div class='candidatesCard_id'>ID: ".$can['can_id']."</div>";
          echo "<div class='candidatesCard_rank'><span class='rank'>".($key+1)."</span></div>";
          echo "</a>";
        }
        ?>
        
      </div>
    </div>
    <!-- noti -->
    <?php include './components/notication.php' ?>
  </div>
</section>

<?php include './components/footer.php' ?>