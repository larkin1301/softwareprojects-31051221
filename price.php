<?php
session_start();
require_once('config/db.php');
require_once('config/helpers.php');

$prod = "SELECT * from products";
$handle = $pdo->prepare($prod);
$handle->execute();
$getAllProducts = $handle->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Cool T-Shirt Shop';
$metaDesc = 'Demo PHP shopping cart get products from database';

include('comp/header.php');
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

            <section class="container" >
                <div class="row" style="padding:110px 0 110px 0">

                        <?php
                        foreach($getAllProducts as $product)
                        {

                            ?>
                            <div class="col-md-3  mt-2">
                                <div class="card">

                                    <div class="card-body">
                                        <h5 class="card-title">

                                                <?php echo $product['product_name']; ?>

                                        </h5>
                                        <strong>$ <?php echo $product['price']?></strong>

                                        <p class="card-t">
                                            <?php echo substr($product['short_description'],0,50) ?>'...
                                        </p>
                                        <p class="card-text">
                                            <a href="step_one.php?product=<?php echo $product['id']?>" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                </div>
            </section>
<?php include('comp/footer.php');?>
        </div>
    </body>
</html>
