<?php

session_start();
require_once 'includes/db_connect.php';

$ID = $_GET['id'];

if ($ID) {

    try {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id',$ID, PDO::PARAM_INT);
        $stmt->execute();

        // Store a success message
        $_SESSION['success_msg'] = "Product deleted successfully.";

    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error_msg'] = "Something went wrong. Please try again.";
        exit;
    }
}

header("Location: cart.php");
exit;