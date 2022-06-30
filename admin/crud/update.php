<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: ../login.php");
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
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE movies SET title = ?, short_desc = ?, status = ? WHERE id = ?');

        $stmt->execute([$title, $desc, $status,$_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM movies WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $mov_det = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$mov_det) {
        exit('No movie doesn\'t exist with that ID!');
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

        <h1>Edit movie <?=$mov_det['title']?></h1>
        <form action="/admin/crud/update.php?id=<?=$mov_det['id']?>" method="post">
            <div class="form-group">
                <label>Movie title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($t_err)) ? 'is-invalid' : ''; ?>" value="<?=$mov_det['title']?>">
                <span class="invalid-feedback"><?php echo $t_err; ?></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="textarea" name="desc" class="form-control <?php echo (!empty($d_err)) ? 'is-invalid' : ''; ?>" value="<?=$mov_det['short_desc']?>">
                <span class="invalid-feedback"><?php echo $d_err; ?></span>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control <?php echo (!empty($s_err)) ? 'is-invalid' : ''; ?>">
                    <option value="30">Select status</option>
                    <?php
                        if ($mov_det['status'] == 0){
                            echo '<option value="0" selected>Recenlty added</option>
                    <option value="1">Popular</option>';
                        }else{
                            echo '<option value="0">Recenlty added</option>
                    <option value="1"  selected>Popular</option>';
                        }
                    ?>

                </select>

                <span class="invalid-feedback"><?php echo $s_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>

        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php header( "refresh:3;url=/admin/movies.php" );?>
        <?php endif; ?>

    </section>

    <?php include('../comp/footer.php') ?>
</div>
</body>
</html>

