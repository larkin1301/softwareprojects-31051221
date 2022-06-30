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
$allMovies = "select * from admin_users";
$handle = $pdo->prepare($allMovies);
$handle->execute();
$users = $handle->fetchAll();
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

        <h1>Users</h1>
        <a href="ucrud/insert.php" class="btn btn-primary">Add new user</a>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Last name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Date created</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $us): ?>
                <tr>
                    <td><?php echo $us['name']?></td>
                    <td><?php echo $us['surname']?></td>
                    <td><?php echo $us['username']?></td>
                    <td><?php echo $us['email']?></td>
                    <td><?php echo $us['created_at']?></td>
                    <td><?php if($us['is_admin'] == 0){echo 'NO';}else{echo "Yes";}?></td>

                    <td>
                        <a style="color:var(--primary)" href="ucrud/update.php?id=<?=$us['id']?>" class="edit">Edit</a>

                        <a style="color:var(--primary)" href="ucrud/delete.php?id=<?=$us['id']?>" class="edit">Delete</a>

                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>


    </section>

    <?php include('comp/footer.php') ?>
</div>
</body>
</html>