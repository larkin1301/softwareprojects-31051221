<?php
session_start();

if(isset($_POST['action']) && $_POST['action'] == 'empty')
{
    unset($_SESSION['cart_items']);
    echo json_encode(['msg' => 'success']);
    exit();
}