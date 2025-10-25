<?php

session_start();

$success_msg = $_SESSION['success_msg'] ?? '';
$error_msg = $_SESSION['error_msg'] ?? '';

unset($_SESSION['success_msg']);
unset($_SESSION['error_msg']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand mx-5" href="#">Admin Dashboard</a>
    </div>
  </nav>

  <div class="mt-5 d-flex flex-column justify-content-center align-items-center">
    <!-- Display success or error messages -->
     <?php if ($success_msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
     <?php endif; ?>

     <?php if ($error_msg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
     <?php endif; ?>

    <h1 class="mb-3">Welcome, Admin!</h1>
    <p class="mb-3">Use the buttons below to manage your store.</p>

    <a href="products.php" class="btn btn-primary mb-3">Manage Products</a>
    <a href="add_product.php" class="btn btn-success">Add New Product</a>
  </div>

</body>
</html>
