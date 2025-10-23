<?php
require_once '../includes/db_connect.php';

try {
    $query = "SELECT * FROM products;";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
    die();
}