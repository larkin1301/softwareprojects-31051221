<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: ../login.php");
    exit;
}


require_once('../../config/db.php');
require_once('../../config/helpers.php');
$title = trim($_POST["title"]);
$desc = trim($_POST["desc"]);
$status = trim($_POST["status"]);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check input errors before inserting in database
    if(empty(trim($_POST["title"]))){
        $t_err = "Title required.";
    } elseif(empty(trim($_POST["desc"]))){
        $d_err = "description required.";
    }elseif(empty(trim($_POST["status"] || trim($_POST["status"] > 1)))){
        $s_err = "Status required.";
    }else {
        if (empty($t_err) && empty($d_err) && empty($s_err)) {

            // Prepare an insert statement
            $sql = "INSERT INTO movies (title, short_desc, status) VALUES (:title, :desc, :status)";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $param_desc, PDO::PARAM_STR);
                $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);


                // Set parameters
                $param_title = $title;
                $param_desc = $desc;
                $param_status = $status;


                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to login page
                    header("location: /admin/movies.php");
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
        unset($pdo);
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
    <link rel="stylesheet" type="text/css" href="../../assets/css/main.css">

</head>
<body id="home">
<div class="wrapper">

    <?php include('../comp/header.php') ?>

    <section class="main-container container">

        <h1>Add new movie</h1>
        <form action="/admin/crud/insert.php" method="post">
            <div class="form-group">
                <label>Movie title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($t_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                <span class="invalid-feedback"><?php echo $t_err; ?></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="textarea" name="desc" class="form-control <?php echo (!empty($d_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $desc; ?>">
                <span class="invalid-feedback"><?php echo $d_err; ?></span>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control <?php echo (!empty($s_err)) ? 'is-invalid' : ''; ?>">
                    <option value="30" selected>Select status</option>
                    <option value="0">Recenlty added</option>
                    <option value="1">Popular</option>
                </select>

                <span class="invalid-feedback"><?php echo $s_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Create">
            </div>

        </form>


    </section>

    <?php include('../comp/footer.php') ?>
</div>
</body>
</html>
