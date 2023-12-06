<?php 
session_start();
$userLogin = $_SESSION['userLogin'];
$username = $userLogin['username'];
$role = $userLogin['role'];

if($role != 'admin') {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin-Voting</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
    

    <link rel="stylesheet" href="./style.css" />
</head>

<body>
    <?php include './ad_compo/sidebar.php' ?>
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                <?php echo $pageName; ?>
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>

            <div class="user-wrapper">
                <img src="./images/formUserImg2.png" width="60px" height="60px" alt="" style="object-fit: contain;"/>
                <div>
                    <h4><?php echo $username; ?></h4>
                    <small><?php echo $role; ?></small>
                </div>
            </div>
        </header>