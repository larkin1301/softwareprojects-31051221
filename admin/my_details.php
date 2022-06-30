<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinadm"]) || $_SESSION["loggedinadm"] !== true){
    header("location: login.php");
    exit;
}
require_once "../config/db.php";
$sql = "SELECT * FROM admin_users WHERE id = :id";
if($stmt = $pdo->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);

    // Set parameters
    $param_id = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    unset($stmt);
}
unset($pdo);
foreach ($result as $row){
    $myname = $row['name'];
    $myuser = $row['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="wrapper">

        <?php include('comp/header.php')?>
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b></h1>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>
        <?php include('comp/footer.php')?>
    </div>
</body>
</html>