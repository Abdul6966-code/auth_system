<?php
include_once 'guest.php';

include_once 'app/User.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process registration logic here
    $user = new User;
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    
    if($user->register()) {
        // Registration successful
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "Registration failed!";
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Auth System - Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 pt-4">
                <h2>Register Form</h2>
                <form method="POST" action="register.php">

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm password" name="confirm_password">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="login.php" class="btn btn-link">Already have an account? Login</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>