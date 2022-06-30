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
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $is_adm = isset($_POST['is_admin']) ? $_POST['is_admin'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE admin_users SET name = ?, surname = ?, username = ?, email = ?, is_admin = ? WHERE id = ?');

        $stmt->execute([$name, $surname, $username, $email, $is_adm, $_GET['id']]);

        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $u_det = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$u_det) {
        exit('No user exist with that ID!');
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

        <h1>Edit username <?=$u_det['name']?></h1>
        <form action="/admin/ucrud/update.php?id=<?=$u_det['id']?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($t_err)) ? 'is-invalid' : ''; ?>" value="<?=$u_det['name']?>">
                        <span class="invalid-feedback"><?php echo $t_err; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="surname" class="form-control <?php echo (!empty($d_err)) ? 'is-invalid' : ''; ?>" value="<?=$u_det['surname']?>">
                        <span class="invalid-feedback"><?php echo $d_err; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($d_err)) ? 'is-invalid' : ''; ?>" value="<?=$u_det['username']?>">
                        <span class="invalid-feedback"><?php echo $d_err; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($d_err)) ? 'is-invalid' : ''; ?>" value="<?=$u_det['email']?>">
                        <span class="invalid-feedback"><?php echo $d_err; ?></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Is admin</label>
                        <input type="checkbox" name="is_admin" class="" value="<?php if($u_det['is_admin'] == 1){echo "0";}else{echo '1';} ?>" <?php if($u_det['is_admin'] == 1){echo "checked";}else{} ?>>
                        <span class="invalid-feedback"><?php echo $d_err; ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>

        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php header( "refresh:3;url=/admin/users.php" );?>
        <?php endif; ?>

    </section>

    <?php include('../comp/footer.php') ?>
</div>
</body>
</html>

