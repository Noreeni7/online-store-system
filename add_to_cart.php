<?php

session_start();

require_once 'includes/db_connect.php';

// ================ storing the items in the user’s session ============
$id = $_GET['id'] ?? null;

// create cart if it doesn’t exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// add or increment product quantity
if ($id !== null) {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++; // add one more if already in cart
    }
}

// ============ display the cart items (with product details from your products table). ===========
$cart_items = $_SESSION['cart'] ?? [];

// get all product ids in the cart
if (!empty($cart_items)) {
    $ids = array_keys($cart_items);

    // implode(separator, array): Convert the array of product IDs into a comma-separated string for the SQL IN clause
    // create placeholders (?, ?, ?) based on number of IDs
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $query = "SELECT * FROM products WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}

header("Location: index.php");
exit();
