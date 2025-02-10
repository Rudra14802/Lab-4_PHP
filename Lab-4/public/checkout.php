<?php
// public/checkout.php

session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Calculate the total price of items in the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Process the order (In a real app, save order to the database)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate order processing
    require '../config/db.php';
    $userId = 1;  // Assuming the user is logged in and their ID is 1
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $stmt->execute([$userId, $totalPrice]);

    // Get the last order ID
    $orderId = $pdo->lastInsertId();

    // Save order items
    foreach ($_SESSION['cart'] as $guitarId => $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, guitar_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $guitarId, $item['quantity'], $item['price']]);
    }

    // Update the inventory
    foreach ($_SESSION['cart'] as $guitarId => $item) {
        $stmt = $pdo->prepare("UPDATE guitars SET quantity = quantity - ? WHERE id = ?");
        $stmt->execute([$item['quantity'], $guitarId]);
    }

    // Clear the cart after successful order
    unset($_SESSION['cart']);
    header('Location: order_summary.php?order_id=' . $orderId);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6uN6+f8e5olWnCV1mRjdu6pV5SzBe3lIZFfP1jJUl5c0fMGyMuHqGf0WqO" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .checkout-btn {
            background-color: #0d6efd;
            color: white;
            font-size: 1.2em;
            padding: 10px 30px;
            border: none;
            border-radius: 50px;
            transition: background 0.3s ease;
        }
        .checkout-btn:hover {
            background-color: #0d6efd;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
            font-size: 1.1em;
            color: #0d6efd;
        }
        .back-link:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center text-warning">Checkout</h1>

        <div class="text-center mb-4">
            <p><strong>Total Price:</strong> $<?php echo number_format($totalPrice, 2); ?></p>
        </div>

        <form action="checkout.php" method="POST">
            <div class="text-center">
                <button type="submit" class="checkout-btn">Confirm Purchase</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="cart.php" class="back-link">Go Back to Cart</a>
        </div>
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybP4T2vuXot4uD6DujAy0nF3w7h5f5VJ26hC1bJ5vAN9hCfGp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Vx6D4xkB2t06zZdf6eFJwM2ggm5gGz5L5V5g5jQH7HgiOni" crossorigin="anonymous"></script>
</body>
</html>
