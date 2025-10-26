<?php

session_start();

$id = $_GET['id'];

if ($id !== null && isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
        unset($_SESSION['cart'][$id]); // remove item when it reaches 0
        }
}

header("Location: cart.php");
exit;