<?php
// public/order_summary.php

session_start();

if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$orderId = $_GET['order_id'];

// Fetch order details from the database
require '../config/db.php';
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found!";
    exit();
}

// Fetch the order items
$stmt = $pdo->prepare("SELECT * FROM order_items oi JOIN guitars g ON oi.guitar_id = g.id WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
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
            text-align: center;
        }

        h1 {
            color: #0d6efd;
            font-size: 2em;
            margin-bottom: 20px;
        }

        h2 {
            color: #444;
            font-size: 1.5em;
            margin-top: 20px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #555;
        }

        /* Order List Styling */
        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 12px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 1.1em;
        }

        /* Button Styling */
        .back-btn {
            display: inline-block;
            background-color:#0d6efd;
            color: white;
            padding: 12px 20px;
            font-size: 1.1em;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Summary</h1>

        <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
        <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>

        <h2>Items in your Order</h2>
        <ul>
            <?php foreach ($orderItems as $item) { ?>
                <li><?php echo htmlspecialchars($item['name']) . ' (x' . $item['quantity'] . ') - $' . number_format($item['price'], 2); ?></li>
            <?php } ?>
        </ul>

        <a href="index.php" class="back-btn">Back to Home</a>
    </div>
</body>
</html>
