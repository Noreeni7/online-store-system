<?php

require_once 'includes/db_connect.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $query = "SELECT id, pwd FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['pwd'])) {
                $success_msg = "Login success";
            } else {
                $error_msg = "Invalid email or password";
            }
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $error_msg = "Something went wrong. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
    
    <div class="d-flex justify-content-center align-items-center vh-100">
        <form class="p-4 border rounded shadow" method="post">

            <!-- Display message -->
            <?php if ($success_msg) { ?>
                        <div class="alert alert-success"><?= $success_msg ?></div>
            <?php  } ?>

            <?php if ($error_msg) { ?>
                        <div class="alert alert-danger"><?= $error_msg ?></div>
            <?php  } ?>

            <h3 class="text-center mb-3">Login</h3>
            <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>

            <div class="mt-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-warning mt-3">Login</button>
            </div>

        </form>
    </div>

</body>
</html>