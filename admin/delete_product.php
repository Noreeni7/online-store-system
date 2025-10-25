<?php

session_start();

require_once '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $query = "DELETE FROM products WHERE id = :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success_msg'] = "Product deleted successfully";
        header('Location: index.php');
        die();

    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error_msg'] = "Something went wrong. Please try again.";
        header("Location: index.php");
        exit;
    }
}else{
    $_SESSION['error_msg'] = "Invalid request.";
    header("Location: index.php");
    exit();
}


