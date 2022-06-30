<?php
require_once('config/db.php');
require_once('config/helpers.php');
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
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    </head>
    <body id="home">
      <div class="wrapper">

        <?php include('comp/header.php') ?>

        <section class="main-container" >
          <div class="location" id="home">
              <h1>Our movie gallery</h1>
              <div class="box">
                  <?php foreach($movies as $mov): ?>
                      <div class="movie-container">
                          <a id="alert" href="login.php"><img src="../assets/img/placeholder.png" alt=""></a>
                          <p class="bottom-left"><?php echo $mov['title']?></p>

                      </div>
                  <?php endforeach;?>

              </div>
          </div>
        </section>

        <?php include('comp/footer.php') ?>
      </div>
    </body>
</html>