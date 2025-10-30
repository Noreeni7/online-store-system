<?php
require_once '../includes/db_connect.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

try {
    $query = "SELECT * FROM products WHERE id = :id;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }

} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

// 3. Handle form submission
$success_msg = '';
$error_msg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $image = trim($_POST['image']);

    if (empty($name) || empty($price) || empty($image)) {
        $error_msg = "Name, price, and image are required!";
    }else {
        // Continue updating products in the database
        try {
            $query = "UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $success_msg = "Product updated successfully";

        } catch (PDOException $e) {
             $error_msg = "Database error: " . htmlspecialchars($e->getMessage());
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <!-- Display success or error messages -->
        <?php
            if ($success_msg) {
                echo '<div class="alert alert-success">'. $success_msg . '</div>';
            }
            if ($error_msg) {
                echo "<div class='alert alert-danger'>$error_msg</div>";
            }
        ?>

        <div class="d-flex justify-content-center align-items-center vh-100">
        <form class="p-4 border rounded shadow" style="width: 30vw;">
        <h3 class="text-center mb-3">Update product</h3>
            <div class="mt-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>">
            </div>

            <div class="mt-3">
                <label class="form-label">Description</label>
               <textarea name="description" class="form-control"><?php echo htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mt-3">
                <label class="form-label">Price (Ksh)</label>
                <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']) ?>">
            </div>

            <div class="mt-3">
                <label class="form-label">Image URL</label>
                <input type="text" name="image" class="form-control" value="<?php echo htmlspecialchars($product['image']) ?>">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Product</button>
        </form>
    </div>

</body>
</html>