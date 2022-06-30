<?php 
    session_start();
    require_once('config/db.php');
    require_once('config/helpers.php');

    if(isset($_GET['action'],$_GET['item']) && $_GET['action'] == 'remove')
    {
        unset($_SESSION['cart_items'][$_GET['item']]);
        header('location:cart.php');
        exit();
    }

    //pre($_SESSION);
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

<section class="container" style="padding:110px 0 110px 0">
    <h1>Your cart</h1>
<div class="row">
    <div class="col-md-12">
        <?php if(empty($_SESSION['cart_items'])){?>
        <table class="table">
            <tr>
                <td>
                    <p>Your cart is empty</p>
                </td>
            </tr>
        </table>
        <?php }?>
        <?php if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){?>
        <table class="table">
           <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th width="130px" style="text-align: right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalCounter = 0;
                    $itemCounter = 0;
                    foreach($_SESSION['cart_items'] as $key => $item){


                    
                    $total = number_format($item['product_price'],2);
                    $totalCounter+= number_format($total,2);

                    ?>
                    <tr>
                        <td>
                           <?php echo $item['product_name'];?>

                        </td>
                        <td>
                            $<?php echo $item['product_price'];?>
                        </td>

                        <td>
                            <?php echo $total;?>

                        </td>
                        <td style="text-align: right">
                            <a href="cart.php?action=remove&item=<?php echo $key?>" style="color:#fff">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php }?>
                <tr class="border-top border-bottom">
                    <td><button class="btn btn-danger btn-sm" id="emptyCart">Clear Cart</button></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><strong>Cart total: $<?php echo number_format($totalCounter,2);?></strong></td>
                </tr> 
                </tr>
            </tbody> 
        </table>
        <div class="row">
            <div class="col-md-12">
				<a href="checkout.php">
					<button class="btn btn-primary btn-lg float-right">Checkout</button>
				</a>
            </div>
        </div>
        
        <?php }?>
    </div>
</div>
    </section>
    <?php include('comp/footer.php');?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</div>
</body>
    </html>
