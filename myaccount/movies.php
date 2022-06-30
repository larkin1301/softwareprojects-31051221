<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

require_once('../config/db.php');
require_once('../config/helpers.php');
$popular = "select * from movies where status = 1";
$handle = $pdo->prepare($popular );
$handle->execute();
$pop = $handle->fetchAll();
$added = "select * from movies where status = 0";
$handle = $pdo->prepare($popular );
$handle->execute();
$add = $handle->fetchAll();
//pre($_SESSION);
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">

</head>
<body id="home">
<div class="wrapper">

    <?php include('../comp/header.php') ?>

    <section class="main-container" >
        <div class="location" id="home">
            <h1>Popular</h1>
            <div class="box">
            <?php foreach($pop as $row): ?>
                <div class="movie-container">
                    <a href=""><img src="../assets/img/placeholder.png" alt=""></a>
                    <p class="bottom-left"><?php echo $row['title']?></p>
                    <button class="bottom-right btn btn-primary">View</button>
                </div>
            <?php endforeach;?>
            </div>
        </div>
        <div class="location" id="home">
            <h1>Recently added</h1>
            <div class="box">
                <?php foreach($add as $row): ?>
                    <div class="movie-container">
                        <a href=""><img src="../assets/img/placeholder.png" alt=""></a>
                        <p class="bottom-left"><?php echo $row['title']?></p>
                        <button class="bottom-right btn btn-primary">View</button>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </section>




        <?php include('../comp/footer.php') ?>
</div>
</body>
</html>
