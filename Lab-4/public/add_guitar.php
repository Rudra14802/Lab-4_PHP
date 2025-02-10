<?php
// Start session to check login status
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not, redirect to login page
    header('Location: login.php');
    exit;
}

// Code to handle form submission for adding a new guitar (if any)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config/db.php';
    require '../classes/Guitar.php';

    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Create Guitar object and pass PDO instance
    $guitar = new Guitar($pdo);

    // Add the new guitar to the database
    if ($guitar->addGuitar($name, $price, $quantity)) {
        header('Location: index.php');  // Redirect to the main page after adding the guitar
        exit;
    } else {
        echo "Error adding guitar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Guitar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .container1{
            max-width:1000px;
        }

        h1 {
            color: #0d6efd;
            font-size: 2em;
            text-align: center;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color:rgb(0, 0, 0);
            text-decoration: none;
            font-size: 1.1em;
            text-align: center;
        }

        .back-link:hover {
            color: #000;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Add a New Guitar</h1>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Guitar Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" name="price" class="form-control" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Guitar</button>
    </form>

    <a href="index.php" class="back-link d-block text-center">Back to Guitar List</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3J8p3p5B2z5v8ldzK5+zE6M5lhF2jX0+z8FX8pZ3T0kV2HMe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyb6epRv7zjtpvn5W8r0g5+z5/+gg9D4jjqGbEgf9sJkFZ6gAK7iFuD" crossorigin="anonymous"></script>

</body>
</html>
