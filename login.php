<?php

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
            <h3 class="text-center mb-3">Login</h3>
            <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Enter your email">
            </div>

            <div class="mt-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Enter your password">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-warning mt-3">Login</button>
            </div>

        </form>
    </div>

</body>
</html>