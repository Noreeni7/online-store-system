<?php

require_once '../includes/db_connect.php';

try {
    $query = "INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image) ON DUPLICATE KEY UPDATE description = VALUES(description), price = VALUES(price), image = VALUES(image);";
    $stmt = $conn->prepare($query); 
    $products = [
        [
            'name' => 'Air Force',
            'description' => '',
            'price' => '2000.00',
            'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8c2hvZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=500'
        ],
        [
            'name' => 'Sports Shoes',
            'description' => '',
            'price' => '1000.00',
            'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=870'
        ],
        [
            'name' => 'Sneakers',
            'description' => '',
            'price' => '2500.00',
            'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c2hvZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=500'
        ],
        [
            'name' => 'Nike shoes',
            'description' => '',
            'price' => '2500.00',
            'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=464'
        ],
        [
            'name' => 'Running shoes',
            'description' => '',
            'price' => '2500.00',
            'image' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8c2hvZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=500'
        ],
    ];

    foreach ($products as $product) {
        $stmt->execute($product);
    }

    echo "Product inserted successfully";

} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
}