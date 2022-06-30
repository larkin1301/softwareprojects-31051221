<?php
/* Database credentials. */
define('DB_SERVER', 'localhost');//replace localhost with your mysql path
define('DB_USERNAME', 'root');//replace with your username
define('DB_PASSWORD', '123456');//replace with your password
define('DB_NAME', 'movies');//replace with your db

/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
define('PRODUCT_IMG_URL','assets/product-images/');
?>