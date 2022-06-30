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
$user_id = $_SESSION['username'];
$sql = "SELECT o.user_id AS username, o.first_name AS f_name, od.product_name AS p_name, o.created_at as c_date, p.short_description AS s_desc , p.price as p_price FROM orders o
INNER JOIN order_details od
ON o.id = od.order_id
INNER JOIN products p
ON od.product_id = p.id
WHERE o.user_id =:username";

$handle = $pdo->prepare($sql);
$params = [
    ':username' => $user_id
];
$handle->execute($params);
$subs = $handle->fetchAll();

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

        <?php include('../comp/header.php')?>
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["name"]).' '.htmlspecialchars($_SESSION["surname"]); ?></b>. Welcome back.</h1>
        <?php if (!$subs){ ?>
            <p>You don`t have any active subscription. Purchase one <a href="/price.php">here</a></p>
        <?php }else{ ?>
            <p>Your active subscription</p>
            <div class="container">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Registered</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>


                        <?php foreach($subs as $row): ?>
                        <tr>
                        <td><?php echo $row['p_name'];?></td>
                        <td><?php echo $row['p_price'];?></td>

                        <td><?php echo $row['c_date'];?></td>
                        <td width="600px"><?php echo $row['s_desc'];?></td>
                        </tr>
                    <?php endforeach;?>



                    </tbody>
                </table>
            </div>

        <?php } ?>
        <?php include('../comp/footer.php') ?>
    </div>
</body>
</html>