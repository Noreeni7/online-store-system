<?php

require_once '../includes/db_connect.php';

// ----- Initialize variables -----
$name = $description = $price = $image = '';
$success_msg = '';
$error_msg = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    if (empty($name) || empty($price) || empty($image)) {
        $error_msg = 'Name, price and image fields required!';
    } else if (!is_numeric($price) || floatval($price) <= 0) {
        $error_msg = 'Price must be a number greater than 0';
    }else {
        try {
            $query = "INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image) ON DUPLICATE KEY UPDATE description = VALUES(description), price = VALUES(price), image = VALUES(image);";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);

            $stmt->execute();

            $success_msg ='Product added successfuly!';
            
        } catch (PDOException $e) {
            // Log error, do not show raw DB error
                    error_log($e->getMessage());
                    $error_msg = "Something went wrong. Please try again later";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container">

        <!-- Display success or error messages -->
        <?php if ($error_msg) { ?>
                    <div class="alert alert-danger"><?= $error_msg ?></div>
        <?php  }
        ?>

        <?php if ($success_msg): ?>
            <div class="alert alert-success"><?= $success_msg?></div>
        <?php endif
        ?>

        <div class="d-flex justify-content-center align-items-center vh-100">
        <form class="p-4 border rounded shadow" style="width: 30vw;">
        <h3 class="text-center mb-3">Add product</h3>
            <div class="mt-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" value="<?= htmlspecialchars($name) ?>">
            </div>

            <div class="mt-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter product description"><?= htmlspecialchars($description) ?></textarea>
            </div>

            <div class="mt-3">
                <label class="form-label">Price</label>
                <input type="text" name="price" class="form-control" placeholder="Enter price" value="<?= htmlspecialchars($price) ?>">
            </div>

            <div class="mt-3">
                <label class="form-label">Image URL</label>
                <input type="text" name="image" class="form-control" placeholder="Enter image URL" value="<?= htmlspecialchars($image) ?>">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Add Product</button>
        </form>
    </div>

</body>

</html>
if (empty($name) || empty($email) || empty($password) || $confirm_password) {
        $error_msg = "Please fill all fields";
    }

    if ($password !== $confirm_password) {
        $error_msg = "Passwords do not match";
    }