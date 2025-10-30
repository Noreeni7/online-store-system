<?php

session_start();
require_once 'includes/db_connect.php';

$cart_count = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    try {
        $query = "SELECT SUM(quantity) as total_items FROM cart WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $cart_count = $result['total_items'] ?? 0;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $cart_count = 0;
    }
} else {
    // Guest user: get from session
    $cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- css style -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    
    <!-- =============================== NAVBAR ================================ -->
    <nav id="nav" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top py-1">
        <div class="container d-flex align-items-center justify-content-between">

            <a href="index.php" class="navbar-brand fw-semibold text-white">MyStore</a>

            <div class="d-flex align-items-center">

                <a href="cart.php" class="nav-link text-white fw-semibold d-md-none me-2">🛒 Cart
                    <?php if ($cart_count > 0): ?>
                        <span class="position-absolute badge text-warning bold-100 fs-5" style="transform: translate(-40%, -17%);"><?= $cart_count ?></span>
                    <?php endif; ?>
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Collapsible Menu -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-pills ms-auto d-flex gap-3">

                    <li class="nav-item d-none d-md-block">
                        <a href="cart.php" class="nav-link text-white fw-semibold">🛒 Cart
                            <?php if ($cart_count > 0): ?>
                                <span class="position-absolute badge text-warning bold-100 fs-5" style="transform: translate(-40%, -17%);"><?= $cart_count ?></span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link text-white fw-semibold">Logout</a>
                        </li>
                        <li class="nav-item">
                        <?php else: ?>
                            <a href="login.php" class="nav-link text-white fw-semibold">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="register.php" class="nav-link text-white fw-semibold">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- =============================== END OF NAVBAR ================================ -->

    <!-- HERO SECTION -->
    <div class="p-5 mt-5 text-center rounded mb-4 hero">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <span class="fs-2">Welcome <span class="text-danger"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <?php } else { ?>
            <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-warning">MyStore</span> 🛍️</h1>
        <?php } ?>


        <p class="lead mb-4">Find the best products.</p>

        <a href="#products" class="btn btn-warning btn-lg fw-semibold px-4 shadow-sm">Shop Now</a>
    </div>

    <!-- MAIN SECTION -->
    <div class="container mt-5 main">
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

    <!-- Bootstrap JS (must be below all HTML) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>


<!-- 
A shorthand for an if–else statement.
condition ? value_if_true : value_if_false;
 -->