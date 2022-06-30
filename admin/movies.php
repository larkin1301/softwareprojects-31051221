<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: login.php");
    exit;
}
$is_admin = $_SESSION['is_admin'];

require_once('../config/db.php');
require_once('../config/helpers.php');
$allMovies = "select * from movies";
$handle = $pdo->prepare($allMovies);
$handle->execute();
$movies = $handle->fetchAll();
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

              <h1>Our movie gallery</h1>
            <a href="crud/insert.php" class="btn btn-primary">Add new movie</a>
            <table class="table">
                <thead>
                <tr>
                    <th>Movie title</th>
                    <th>Short description</th>
                    <th>Movie info</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach($movies as $mov): ?>
                    <tr>
                        <td><?php echo $mov['title']?></td>
                        <td><?php echo $mov['short_desc']?></td>
                        <td><?php if($mov['status'] == 1){ echo 'Popular';}else{echo 'Recently added';}?></td>
                        <td>
                            <a style="color:var(--primary)" href="crud/update.php?id=<?=$mov['id']?>" class="edit">Edit</a>
                        <?php if($is_admin == 1){?>
                            <a style="color:var(--primary)" href="crud/delete.php?id=<?=$mov['id']?>" class="edit">Delete</a>
                        <?php }?>
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