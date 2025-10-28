<?php

session_start();

require_once 'includes/db_connect.php';

$products = [];
$cart_items = [];
// ================ storing the items in the user’s session ============
$id = $_GET['id'] ?? null;

// If user is logged in, load from DB
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        $query = "SELECT p.id, p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 🟢 Convert DB cart to session-like format for display
        $cart_items = [];
        foreach ($products as $p) {
            $cart_items[$p['id']] = $p['quantity'];
        }

    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
} else {
    // Guest user - use session cart
    $cart_items = $_SESSION['cart'] ?? [];
    if (!empty($cart_items)) {
    $ids = array_keys($cart_items);

    // implode(separator, array): Convert the array of product IDs into a comma-separated string for the SQL IN clause
    // create placeholders (?, ?, ?) based on number of IDs
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $query = "SELECT * FROM products WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}



// create cart if it doesn’t exist
//     if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = [];
// }

// add or increment product quantity
// if ($id !== null) {
//    if (!isset($_SESSION['cart'][$id])) {
//     $_SESSION['cart'][$id] = 1;
//    } else {
//     $_SESSION['cart'][$id]++; // add one more if already in cart
// }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">

    <!-- css style -->
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->

</head>

<body>
    <div class="container">
        <h2 class="mb-4 text-center">🛒 Your Shopping Cart</h2>

        <?php if (!empty($products)): ?>
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Price (Ksh)</th>
                        <th>Quantity</th>
                        <th>Total per product (Ksh)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    foreach ($products as $product) {
                        // Check if user is logged in or not
                        $quantity = isset($_SESSION['user_id']) ? $product['quantity'] : $cart_items[$product['id']];
                        $total = $quantity * $product['price'];
                        $grand_total += $total;
                    ?>

                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= number_format($product['price'], 2) ?></td>
                            <td><?= htmlspecialchars($quantity) ?></td>
                            <td><?= number_format($total) ?></td>
                            <td class="g-3"><a href="increase_quantity.php?id=<?= $product['id'] ?>" class="me-4">+</a>
                            <a href="decrease_quantity.php?id=<?= $product['id'] ?>" class="me-4">-</a>
                            <a href="remove_from_cart.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm me-4">Remove</a></td>
                        </tr>
                    <?php   }
                    ?>

                    <tr class="table-success">
                        <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                        <td><?= number_format($grand_total, 2) ?></td>
                    </tr>
                </tbody>
            </table>

        <?php else: ?>
            <div class="alert alert-info text-center">Your Cart is empty</div>
        <?php endif; ?>

    </div>
</body>
</html>