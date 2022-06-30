<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: login.php");
    exit;
}
$is_admin = $_SESSION['is_admin'];
if ($is_admin != 1){
    header("location: dashboard.php");
    exit;
}

require_once('../config/db.php');
require_once('../config/helpers.php');
$allSubs = "SELECT o.user_id AS username, o.first_name AS f_name, o.last_name AS l_name, od.product_name AS p_name, o.created_at as c_date, p.short_description AS s_desc , p.price as p_price FROM orders o
INNER JOIN order_details od
ON o.id = od.order_id
INNER JOIN products p
ON od.product_id = p.id";
$handle = $pdo->prepare($allSubs);
$handle->execute();
$subs = $handle->fetchAll();
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">

</head>
<body id="home">
<div class="wrapper">

    <?php include('comp/header.php') ?>

    <section class="main-container container">

        <h1>Active subscriptions</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Package name</th>
                <th>Purchased date</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($subs as $sub): ?>
                <tr>
                    <td><?php echo $sub['username']?></td>
                    <td><?php echo $sub['f_name'].' '.$sub['l_name']?></td>
                    <td><?php echo $sub['p_name']?></td>
                    <td><?php echo $sub['c_date'] ?></td>
                    <td><?php echo $sub['p_price']?></td>

                </tr>
            <?php endforeach;?>

            </tbody>
        </table>


    </section>

    <?php include('comp/footer.php') ?>
</div>
</body>
</html>