<?php

session_start();
require_once 'includes/db_connect.php';

if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
} else {
    $cart_count = 0;
}

try {
    $query = "SELECT * FROM products;";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MyStore</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- css style -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">MyStore</a>
            <div>
                <a href="cart.php" class="position-relative btn btn-outline-light me-2">🛒 Cart
                    <?php if ($cart_count>0): ?>
                        <span class="position-absolute badge text-warning bold-100 fs-5" style="transform: translate(-40%, -17%);"><?= $cart_count ?></span>
                    <?php endif; ?>
                </a>
                <a href="login.php" class="btn btn-outline-light">Login</a>
                <a href="register.php" class="btn btn-outline-light">Register</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="hero p-5 mt-5 text-center rounded mb-4 bg-info">
        <h1>Welcome to MyStore!</h1>
        <p class="lead">Find the best products.</p>
    </div>

    <!-- MAIN SECTION -->
    <div class="container mt-5">
        <div class="d-flex justify-content-center flex-wrap gap-4">

            <?php

            foreach ($products as $product) {
            ?>
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="card-text">Price: <?php echo htmlspecialchars($product['price']); ?></p>
                        <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        &copy; <?= date('Y'); ?> MyStore. All rights reserved.
    </footer>

</body>

</html>


<!-- 
A shorthand for an if–else statement.
condition ? value_if_true : value_if_false;
 -->