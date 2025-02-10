<?php
// Start session
session_start();

// Check if user is already logged in and redirect them to the index page
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

require '../config/db.php';
require '../classes/User.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $user = new User($pdo);
    
    // Check login credentials
    if ($user->login($username, $password)) {
        $_SESSION['username'] = $username;  // Set session username
        header('Location: index.php'); // Redirect to the main page after login
        exit;
    } else {
        $error = "Invalid username or password.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom Styles */
        body {
            background-color: #f7f7f7;
            padding-top: 50px;
        }
        .container {
            max-width: 400px;
        }
        .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Login</h3>

            <!-- Display error message if login fails -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <a href="register.php" class="register-link text-primary">Don't have an account? Register here</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3J8p3p5B2z5v8ldzK5+zE6M5lhF2jX0+z8FX8pZ3T0kV2HMe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyb6epRv7zjtpvn5W8r0g5+z5/+gg9D4jjqGbEgf9sJkFZ6gAK7iFuD" crossorigin="anonymous"></script>

</body>
</html>
