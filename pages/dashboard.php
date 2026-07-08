<?php pageAdd("includes/header.php"); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 pt-4">
                <h2>User Dashboard</h2>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
                <a href="logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
<?php pageAdd("includes/footer.php"); ?>