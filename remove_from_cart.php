<?php
session_start();

$ID = $_GET['id'];

if (isset($ID) && isset($_SESSION['cart'][$ID])) {
    unset($_SESSION['cart'][$ID]); // remove only from cart
    $_SESSION['success_msg'] = "Item removed from cart.";
}

header("Location: cart.php");
exit;
