<?php
session_start();

if(!isset($_SESSION['confirm_order']) || empty($_SESSION['confirm_order']))
{
    header('location:index.php');
    exit();
}

require_once('config/db.php');
require_once('config/helpers.php');





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
    <section class="container" >
<div class="row" style="padding:110px 0 110px 0">
    <div class="col-md-12">
        <h1>Thank you!</h1>
        <p>
            Your order has been placed.
            <?php unset($_SESSION['confirm_order']);?>
        </p>
    </div>
</div>
    </section>
    <?php include('comp/footer.php') ?>
</div>
</body>
</html>