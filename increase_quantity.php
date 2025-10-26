<?php

session_start();

$id = $_GET['id'];

if ($id !== null && isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
}

header("Location: cart.php");
exit;