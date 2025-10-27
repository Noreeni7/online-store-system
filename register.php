<?php

require_once 'includes/db_connect.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Vaidation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_msg = "Please fill all fields";
    }

    if ($password !== $confirm_password) {
        $error_msg = "Passwords do not match";
    }

    if (!$error_msg) {
        try {

            // Check if email already exists
            $checkQuery = "SELECT id FROM users WHERE email = :email";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                $error_msg = "Email already registered. Please use another email";
            } else {
                $query = "INSERT INTO users (name, email, pwd, role, created_at) VALUES (:name, :email, :password, :role, :created_at)";
                $stmt = $conn->prepare($query);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $role = 'user'; 
                $created_at = date('Y-m-d H:i:s');

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':created_at', $created_at);

                if ($stmt->execute()) {
                    // Redirect to login page
                    header('Location: login.php');
                    exit();
                } else {
                    $error_msg = "Something went wrong. Please try again";
                }
            }
        } catch (PDOException $e) {
            // die("Database error: " . $e->getMessage());
            $error_msg = "Something went wrong. Please try again";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <form class="p-4 border rounded shadow" style="width: 30vw;" method="post">

            <?php if ($success_msg) { ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
            <?php } ?>

            <?php if ($error_msg) { ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
            <?php } ?>

            <h3 class="text-center mb-3">Register</h3>
            <div class="mt-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name">
            </div>

            <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>

            <div class="mt-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div>

            <div class="mt-3">
                <label class="form-label">Confirm password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </div>

        </form>
    </div>

</body>

</html>