<?php
// Include the database connection and the Guitar class
require '../config/db.php';
require '../classes/Guitar.php';

// Start the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Ensure a guitar ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $guitarId = $_GET['id'];
    
    // Instantiate the Guitar class
    $guitar = new Guitar($pdo);

    // Check if there are any orders referencing this guitar
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM order_items WHERE guitar_id = ?");
    $stmt->execute([$guitarId]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // There are orders referencing the guitar, so we can't delete it
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Delete Guitar</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    text-align: center;
                    padding: 50px;
                }
                .container {
                    max-width: 500px;
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    margin: auto;
                }
                .error-message {
                    background-color: #f8d7da;
                    color: #721c24;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                }
                .back-btn {
                    display: inline-block;
                    background-color: #0d6efd;
                    color: white;
                    padding: 12px 20px;
                    font-size: 1.1em;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background 0.3s ease;
                }
                .back-btn:hover {
                    background-color: #0d6efd;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Delete Guitar</h1>
                <div class="error-message">
                    <p>Cannot delete the guitar. It is referenced in one or more orders.</p>
                </div>
                <a href="index.php" class="back-btn">Back to Guitar Shop</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }

    // Proceed with deleting the guitar if no orders are referencing it
    try {
        // Delete the related order items first (optional, only if you want to manually delete them)
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE guitar_id = ?");
        $stmt->execute([$guitarId]);

        // Now delete the guitar from the guitars table
        $stmt = $pdo->prepare("DELETE FROM guitars WHERE id = ?");
        $stmt->execute([$guitarId]);

        // Redirect to the main page after successful deletion
        header('Location: index.php');
        exit;

    } catch (PDOException $e) {
        // Handle any errors that may occur during the deletion process
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    text-align: center;
                    padding: 50px;
                }
                .container {
                    max-width: 500px;
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    margin: auto;
                }
                .error-message {
                    background-color: #f8d7da;
                    color: #721c24;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                }
                .back-btn {
                    display: inline-block;
                    background-color: #f7a600;
                    color: white;
                    padding: 12px 20px;
                    font-size: 1.1em;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background 0.3s ease;
                }
                .back-btn:hover {
                    background-color: #ff7f00;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Error</h1>
                <div class="error-message">
                    <p>Error: <?php echo htmlspecialchars($e->getMessage()); ?></p>
                </div>
                <a href="index.php" class="back-btn">Back to Guitar Shop</a>
            </div>
        </body>
        </html>
        <?php
    }
} else {
    // If no valid guitar ID is provided, redirect back to the index page
    header('Location: index.php');
    exit;
}
?>
