<?php

session_start();

require_once 'includes/db_connect.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if ($id !== null) {
    if ($_SESSION['user_id']) {
        $user_id = $_SESSION['user_id'];

        try {
            $query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = :id AND product_id = :product_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    } else {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        }
    }
}

header("Location: cart.php");
exit;
