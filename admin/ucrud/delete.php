<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: ../login.php");
    exit;
}
$is_admin = $_SESSION['is_admin'];
if ($is_admin != 1){
    header("location: dashboard.php");
    exit;
}
require_once('../../config/db.php');
require_once('../../config/helpers.php');
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $u_det = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$u_det) {
        exit('User doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM admin_users WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the user :(!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: /admin/users.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/main.css">

</head>
<body id="home">
<div class="wrapper">

    <?php include('../comp/header.php') ?>

    <section class="main-container container">

        <h1>Delete user <?=$u_det['name'].' '.$u_det['surname']?>?</h1>

        <?php if ($msg): ?>
            <p><?=$msg?></p>
            <?php header( "refresh:3;url=/admin/users.php" );?>
        <?php else: ?>
            <p>Are you sure you want to delete usrname  <?=$u_det['name'].' '.$u_det['surname']?>?</p>
            <div class="yesno">
                <a class="btn btn-danger" href="delete.php?id=<?=$u_det['id']?>&confirm=yes">Yes</a>
                <a class="btn-primary btn" href="delete.php?id=<?=$u_det['id']?>&confirm=no">No</a>
            </div>
        <?php endif; ?>
    </section>

    <?php include('../comp/footer.php') ?>
</div>
</body>
</html>


