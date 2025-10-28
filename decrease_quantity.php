<?php

session_start();

require_once 'includes/db_connect.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if ($id !== null) {
    if ($_SESSION['user_id']) {
        $user_id = $_SESSION['user_id'];

        try {
            $query = "SELECT quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                if ($item['quantity'] > 1) {
                    $update = "UPDATE cart 
                               SET quantity = quantity - 1 
                               WHERE user_id = :user_id AND product_id = :product_id";
                    $stmt = $conn->prepare($update);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    // remove if quantity goes below 1
                    $delete = "DELETE FROM cart 
                               WHERE user_id = :user_id AND product_id = :product_id";
                    $stmt = $conn->prepare($delete);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    } else {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]); // remove item when it reaches 0
            }
        }
    }
}

header("Location: cart.php");
exit;
