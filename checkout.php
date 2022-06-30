<?php
session_start();

if(!isset($_SESSION['cart_items']) || empty($_SESSION['cart_items']))
{
    header('location:myaccount/welcome.php');
    exit();
}

require_once('config/db.php');
require_once('config/helpers.php');
$cartItemCount = count($_SESSION['cart_items']);

//pre($_SESSION);

if(isset($_POST['submit'])){
    if(isset($_POST['user_name'], $_POST['first_name'],$_POST['last_name']) && !empty($_POST['user_name']) && !empty($_POST['first_name']) &&
        !empty($_POST['last_name'])){
        $firstName = $_POST['first_name'];
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        $sql = "SELECT id FROM users WHERE username = :username";

            if($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

                // Set parameters
                $param_username = trim($_POST["user_name"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }else{



            //validate_input is a custom function
            //you can find it in helpers.php file
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                $username = validate_input($_POST['user_name']);
                $firstName  = validate_input($_POST['first_name']);
                $lastName   = validate_input($_POST['last_name']);

            }else{
                $username = $_SESSION['username'];
                $firstName  = $_SESSION['name'];
                $lastName   = $_SESSION['surname'];

            }

            if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
               $password = $_POST['password'];
               $r_password = $_POST['r_password'];
                $sqlu = "INSERT INTO users (name, surname, username, password) VALUES (:name, :surname, :username, :password)";
                if($stmt = $pdo->prepare($sqlu)){
                    $password = $_POST['password'];
                    $r_password = $_POST['r_password'];
                    $statement = $pdo->prepare($sqlu);
                    $params = [
                        'name' => $firstName,
                        'surname' => $lastName ,
                        'username' => $username,
                        'password' =>  password_hash($password, PASSWORD_DEFAULT)
                    ];
                    $statement->execute($params);

                }
            }



            $sql = 'insert into orders (user_id, first_name, last_name, order_status,created_at, updated_at) values (:userid, :fname, :lname, :order_status,:created_at, :updated_at)';
            $statement = $pdo->prepare($sql);

            $params = [
                'userid' => $username,
                'fname' => $firstName,
                'lname' => $lastName,
                'order_status' => 'confirmed',
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s')
            ];

            $statement->execute($params);

            if($statement->rowCount() == 1)
            {

                $getOrderID = $pdo->lastInsertId();

                if(isset($_SESSION['cart_items']) || !empty($_SESSION['cart_items']))
                {
                    $sqlDetails = 'insert into order_details (order_id, product_id, product_name, product_price, qty, total_price) values(:order_id,:product_id,:product_name,:product_price,:qty,:total_price)';
                    $orderDetailStmt = $pdo->prepare($sqlDetails);

                    $totalPrice = 0;
                    foreach($_SESSION['cart_items'] as $item)
                    {
                        $totalPrice+=$item['total_price'];

                        $paramOrderDetails = [
                            'order_id' =>  $getOrderID,
                            'product_id' =>  $item['product_id'],
                            'product_name' =>  $item['product_name'],
                            'product_price' =>  $item['product_price'],
                            'qty' =>  $item['qty'],
                            'total_price' =>  $item['total_price']
                        ];

                        $orderDetailStmt->execute($paramOrderDetails);
                    }

                    $updateSql = 'update orders set total_price = :total where id = :id';

                    $rs = $pdo->prepare($updateSql);
                    $prepareUpdate = [
                        'total' => $totalPrice,
                        'id' =>$getOrderID
                    ];

                    $rs->execute($prepareUpdate);

                    unset($_SESSION['cart_items']);
                    $_SESSION['confirm_order'] = true;
                    header('location:thanks.php');
                    exit();
                }
            }
            else
            {
                $errorMsg[] = 'Unable to save your order. Please try again';
            }
        }
    }
    else
    {
        $errorMsg = [];
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            if(!isset($_POST['user_name']) || empty($_POST['user_name'])){
                $errorMsg[] = 'User name is required';
            }else{
                $usernameValue = $_POST['user_name'];
            }
        }else{
            $usernameValue = $_SESSION['username'];
        }
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            if(!isset($_POST['first_name']) || empty($_POST['first_name'])) {
                $errorMsg[] = 'First name is required';
            }else{
                $fnameValue = $_POST['first_name'];
            }
        }else{
            $fnameValue = $_SESSION['name'];
        }

        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            if(!isset($_POST['last_name']) || empty($_POST['last_name'])){
                $errorMsg[] = 'Last name is required';
            }else{
                $lnameValue = $_POST['last_name'];
            }
        }else{
            $lnameValue = $_SESSION['surname'];
        }
        if(!isset($_POST['password']) || empty($_POST['password'])){
            $errorMsg[] = 'password is required';
        }else{
            $passValue = $_POST['password'];
        }
        if(!isset($_POST['r_password']) || empty($_POST['r_password'])){
            $errorMsg[] = 'confirm password';
        }else{
            $r_passValue = $_POST['r_password'];
            if($passValue != $r_passValue){
                $errorMsg[] = "Password did not match.";
            }
        }

    }
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

    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>
<body id="home">
<div class="wrapper">

    <?php include('comp/header.php') ?>

    <section class="container" style="padding:110px 0 110px 0">
    <div class="row mt-3">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="" style="color:#fff">Your cart</span>
                <span class="badge badge-secondary badge-pill"><?php echo $cartItemCount;?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php
                $total = 0;
                foreach($_SESSION['cart_items'] as $cartItem)
                {
                    $total+=$cartItem['total_price'];
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0" style="color:var(--primary)"><?php echo $cartItem['product_name'] ?></h6>
                            <small class="text-muted">Quantity: <?php echo $cartItem['qty'] ?> X Price: <?php echo $cartItem['product_price'] ?></small>
                        </div>
                        <span class="text-muted">$<?php echo $cartItem['total_price'] ?></span>
                    </li>
                    <?php
                }
                ?>

                <li class="list-group-item d-flex justify-content-between">
                    <span style="color:var(--primary)">Total (USD)</span>
                    <strong style="color:var(--primary)">$<?php echo number_format($total,2);?></strong>
                </li>
            </ul>
        </div>

        <div class="col-md-8 order-md-1">

            <?php
            if(isset($errorMsg) && count($errorMsg) > 0)
            {
                foreach($errorMsg as $error)
                {
                    echo '<div class="alert alert-danger">'.$error.'</div>';
                }
            }
            ?>


            <form class="needs-validation" method="POST">
                <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){?>
                <h4>Already have an accout? Login <a href="login.php">here</a></h4>
                <?php }?>
                <h4 class="mb-3">Billing address</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="firstName">First name</label>
                        <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){?>
                        <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" value="<?php echo (isset($fnameValue) && !empty($fnameValue)) ? $fnameValue:''?>" >
                        <?php }else{?>
                            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" value="<?php echo (isset($fnameValue) && !empty($fnameValue)) ? $fnameValue:$_SESSION['name']  ?>" >
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lastName">Last name</label>
                        <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){?>
                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" value="<?php echo (isset($lnameValue) && !empty($lnameValue)) ? $lnameValue:'' ?>" >
                        <?php }else{?>
                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" value="<?php echo (isset($lnameValue) && !empty($lnameValue)) ? $lnameValue:$_SESSION['surname'] ?>" >
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lastName">Username</label>
                        <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){?>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" value="<?php echo (isset($usernameValue) && !empty($usernameValue)) ? $usernameValue:'' ?>" >
                        <?php }else{?>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" value="<?php echo (isset($usernameValue) && !empty($usernameValue)) ? $usernameValue:$_SESSION['username'] ?>" >
                        <?php } ?>
                    </div>
                <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){?>
                    <div class="col-md-6 mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Your password" value="<?php echo (isset($passValue) && !empty($passValue)) ? $passValue:''?>" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="r_password">Repeat</label>
                        <input type="password" class="form-control" id="r_password" name="r_password" placeholder="Repeat password" value="<?php echo (isset($r_passValue) && !empty($r_passValue)) ? $r_passValue:'' ?>" >
                    </div>

                <?php }?>
                </div>
                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>

                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="cashOnDelivery" name="cashOnDelivery" type="radio" class="custom-control-input" checked="" >
                        <label class="custom-control-label" for="cashOnDelivery">Cash on Delivery</label>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit" value="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
    </section>
    <?php include('comp/footer.php');?>

</div>
</body>
</html>