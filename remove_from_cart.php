<?php
session_start();

require_once 'includes/db_connect.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if ($id !== null) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        try {
            $query = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error removing item from cart: " . $e->getMessage());
        }
    } else {
        if (isset($_SESSION['cart'][$ID])) {
            unset($_SESSION['cart'][$ID]); // remove only from cart
            $_SESSION['success_msg'] = "Item removed from cart.";
        }
    }
}

header("Location: cart.php");
exit();
