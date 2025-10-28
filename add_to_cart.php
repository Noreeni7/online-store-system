<?php
session_start();
require_once 'includes/db_connect.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if ($id !== null) {

    if (isset($_SESSION['user_id'])) {
        // Logged-in user
        $user_id = $_SESSION['user_id'];

        // Check if this product already exists in the user's cart
        $query = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // If it exists, increment quantity
            $update = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $conn->prepare($update);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            // Otherwise, insert new row
            $insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)";
            $stmt = $conn->prepare($insert);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    } 
    // Guest user — use session cart
    else {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            $_SESSION['cart'][$id]++;
        }
    }
}

header("Location: index.php");
exit();
