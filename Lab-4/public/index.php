<?php
// public/index.php

require '../config/db.php';
require '../classes/Guitar.php';
session_start();  // Start the session

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$guitars = Guitar::getAllGuitars($pdo);  // Get all guitars from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guitar Shop</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom Styles */
        body {
            background-color: #f7f7f7;
        }
        .container {
            max-width: 1000px;
        }
        .decorative-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            margin-bottom: 30px;
        }
        .guitar-item {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .guitar-item h3 {
            font-size: 1.8em;
            color: #333;
        }
        .guitar-item p {
            font-size: 1.2em;
        }
        .add-to-cart {
            background-color:#0d6efd;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
        }
        .navbar {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<!-- includes/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Guitar Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="add_guitar.php">Add New Guitar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">View Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container">
    
    <h1 class="text-center mb-4">Welcome to the Guitar Shop</h1>

    <h2>Available Guitars</h2>

    <?php if (empty($guitars)) { ?>
        <p>No guitars available at the moment.</p>
    <?php } else { ?>
        <div class="row">
            <?php foreach ($guitars as $guitar) { ?>
                <div class="col-md-4">
                    <div class="guitar-item">
                        <h3><?php echo htmlspecialchars($guitar['name']); ?></h3>
                        <p>Price: $<?php echo number_format($guitar['price'], 2); ?></p>
                        <p>Quantity: <?php echo $guitar['quantity']; ?></p>
                        <p>
                            <a href="edit_guitar.php?id=<?php echo $guitar['id']; ?>" class="btn btn-secondary btn-sm">Edit</a> 
                            <a href="delete_guitar.php?id=<?php echo $guitar['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </p>
                        <p>
                            <a href="cart.php?action=add&id=<?php echo $guitar['id']; ?>" class="btn btn-primary btn-md">Add to Cart</a>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3J8p3p5B2z5v8ldzK5+zE6M5lhF2jX0+z8FX8pZ3T0kV2HMe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyb6epRv7zjtpvn5W8r0g5+z5/+gg9D4jjqGbEgf9sJkFZ6gAK7iFuD" crossorigin="anonymous"></script>

</body>
</html>
