<?php
// Start session to check login status
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

require '../config/db.php';
require '../classes/Guitar.php';

// Get the guitar ID from the URL
$id = $_GET['id'] ?? null;  // Use null coalescing to prevent undefined index errors

// Check if the guitar ID is provided
if (!$id) {
    echo "No guitar ID provided.";
    exit;
}

// Retrieve the guitar data from the database
$guitar = Guitar::getGuitarById($pdo, $id);

if (!$guitar) {
    echo "Guitar not found.";
    exit;
}

// Handle form submission for updating the guitar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form inputs
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    // Check for empty fields
    if (empty($name) || empty($price) || empty($quantity)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($price) || !is_numeric($quantity)) {
        $error = "Price and quantity must be numeric.";
    } else {
        // Create Guitar object and pass PDO instance
        $guitarObj = new Guitar($pdo);
        if ($guitarObj->updateGuitar($id, $name, $price, $quantity)) {
            header('Location: index.php');  // Redirect to the main page after updating the guitar
            exit;
        } else {
            $error = "Error updating guitar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guitar</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
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

        h1 {
            color: #0d6efd;
            font-size: 2em;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Error Message */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #f7a600;
            outline: none;
        }

        /* Button Styling */
        button {
            background-color: #0d6efd;
            color: white;
            padding: 12px 20px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0d6efd;
        }

        /* Back to Guitar List Link */
        a {
            display: inline-block;
            margin-top: 20px;
            color: #0d6efd;
            text-decoration: none;
            font-size: 1.1em;
            text-align: center;
            width: 100%;
        }

        a:hover {
            color: #ff7f00;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Guitar</h1>

        <!-- Display error message if any -->
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Guitar Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($guitar['name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($guitar['price']); ?>" required step="0.01">

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($guitar['quantity']); ?>" required>

            <button type="submit">Update Guitar</button>
        </form>

        <a href="index.php">Back to Guitar List</a>
    </div>
</body>
</html>
