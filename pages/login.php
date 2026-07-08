<!DOCTYPE html>

<html lang="en">

<head>
    <title>Auth System - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 pt-4">
                <h2>Login Form</h2>
                <form method="POST" action="/submit-login">

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="register" class="btn btn-link">Don't have an account? Register</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>