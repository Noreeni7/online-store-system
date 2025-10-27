<?php 

session_start();

// Unset all session variables
$_SESSION = [''];

// Destroy the session completely
session_destroy();

header("Location: index.php");
exit();