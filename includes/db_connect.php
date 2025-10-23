<?php
$host = 'localhost';
$dbname = 'online_store';
$dbusername = 'root';
$dbpassword = 'Sbing254';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$dbusername,$dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// The "charset=utf8" part ensures the database connection uses UTF-8 encoding,
// allowing storage and retrieval of special characters (like accents, emojis, or symbols) correctly.
