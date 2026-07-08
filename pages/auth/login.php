<?php pageAdd("includes/header.php"); ?>
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
<?php pageAdd("includes/footer.php"); ?>