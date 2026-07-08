<?php
include_once 'auth.php';
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <title>Auth System - Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 pt-4">
                <h2>User Dashboard</h2>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>

</html>