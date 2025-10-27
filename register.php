<?php

require_once 'includes/db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <form action="" method="post">
            <div class="mt-3">
                <label class="form-label">Name</label>
                <input type="text" name="name">
            </div>

            <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="text" name="email">
            </div>

            <div class="mt-3">
                <label class="form-label">Password</label>
                <input type="text" name="pwd">
            </div>

            <div class="mt-3">
                <label class="form-label">Confirm password</label>
                <input type="text" name="pwd">
            </div>
        </form>
    </div>

</body>
</html>