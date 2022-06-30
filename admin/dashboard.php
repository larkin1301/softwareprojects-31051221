<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: login.php");
    exit;
}
$is_admin = $_SESSION['is_admin'];
if($is_admin == 1){
    $col = 'col-md-3';
}else{
    $col = 'col-md-4';
}
require_once "../config/db.php";
require_once('../config/helpers.php');
$income = "SELECT SUM(total_price) AS total FROM order_details";
$handle = $pdo->prepare($income);
$handle->execute();
$inc = $handle->fetchAll();
$subscribtions = "SELECT COUNT(*) as subs from orders";
$handle = $pdo->prepare($subscribtions);
$handle->execute();
$subs = $handle->fetchAll();
$users = "select COUNT(*) as active from users";
$handle = $pdo->prepare($users);
$handle->execute();
$us = $handle->fetchAll();
$mov = "select COUNT(*) as movs from movies";
$handle = $pdo->prepare($mov);
$handle->execute();
$movs = $handle->fetchAll();
//pre($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class="wrapper">

    <?php include('comp/header.php')?>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["name"]).' '.htmlspecialchars($_SESSION["surname"]); ?></b></h1>
    <p>Here are some business details</p>
    <div class="main-container container" style="padding-top:110px">
        <div class="row">
            <div class="<?php echo $col;?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Movies uploaded</h5>
                        <h1 class="card-title"><a href="/admin/movies.php"><?=$movs[0]['movs']?></a></h1>
                    </div>
                </div>
            </div>
            <div class="<?php echo $col;?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Active subscriptions</h5>
                        <h1 class="card-title"><a href="/admin/subscriptions.php"><?=$subs[0]['subs']?></a></h1>
                    </div>
                </div>
            </div>
            <div class="<?php echo $col;?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Active users</h5>
                        <h1 class="card-title"><?=$us[0]['active']?></h1>
                    </div>
                </div>
            </div>
            <?php if($is_admin == 1){?>
            <div class="<?php echo $col;?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total income</h5>
                        <h1 class="card-title"><a href="/admin/subscriptions.php">$<?=$inc[0]['total']?></a></h1>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

</div>
<?php include('comp/footer.php') ?>
</body>
</html>
