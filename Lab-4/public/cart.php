<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If the cart is empty, inform the user
$cartEmpty = empty($_SESSION['cart']);

// Add an item to the cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $guitarId = $_GET['id'];

    // Fetch the guitar details from the database
    require '../config/db.php';
    $stmt = $pdo->prepare("SELECT * FROM guitars WHERE id = ?");
    $stmt->execute([$guitarId]);
    $guitar = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($guitar) {
        // Add the guitar to the cart (or increase the quantity if already in the cart)
        if (isset($_SESSION['cart'][$guitarId])) {
            $_SESSION['cart'][$guitarId]['quantity']++;
        } else {
            $_SESSION['cart'][$guitarId] = [
                'name' => $guitar['name'],
                'price' => $guitar['price'],
                'quantity' => 1,
            ];
        }
        header('Location: cart.php'); // Refresh page after adding
        exit();
    }
}

// Remove an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $guitarId = $_GET['id'];
    unset($_SESSION['cart'][$guitarId]);
    header('Location: cart.php');
    exit();
}

// Update the quantity of an item in the cart
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $guitarId => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$guitarId]); // Remove the item if quantity is 0 or less
        } else {
            $_SESSION['cart'][$guitarId]['quantity'] = $quantity;
        }
    }
    header('Location: cart.php');
    exit();
}

// Calculate the total price of items in the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #0d6efd;
        }

        p {
            text-align: center;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #0d6efd;
            color: white;
        }

        .remove-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .remove-btn:hover {
            background-color: #b32d37;
        }

        .checkout-btn {
            display: block;
            text-align: center;
            background-color: #28a745;
            color: white;
            padding: 12px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        button {
            background-color:#0d6efd;
            color: white;
            padding: 12px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Your Shopping Cart</h1>

    <?php if ($cartEmpty) { ?>
        <p>Your cart is empty. <a href="index.php">Browse Guitars</a></p>
    <?php } else { ?>
        <form action="cart.php" method="POST">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Guitar</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $guitarId => $item) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantity[<?php echo $guitarId; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control">
                            </td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <a href="cart.php?action=remove&id=<?php echo $guitarId; ?>" class="remove-btn">Remove</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <button type="submit" name="update_cart">Update Cart</button>
        </form>

        <p><strong>Total Price: $<?php echo number_format($totalPrice, 2); ?></strong></p>

        <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
    <?php } ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3J8p3p5B2z5v8ldzK5+zE6M5lhF2jX0+z8FX8pZ3T0kV2HMe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyb6epRv7zjtpvn5W8r0g5+z5/+gg9D4jjqGbEgf9sJkFZ6gAK7iFuD" crossorigin="anonymous"></script>

</body>
</html>
