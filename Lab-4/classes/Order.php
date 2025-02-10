<?php
// classes/Order.php

class Order {
    private $id;
    private $user_id;
    private $total_price;
    private $status; // 0 for Pending, 1 for Completed
    private $created_at;

    // Constructor
    public function __construct($id = null, $user_id = null, $total_price = 0.0, $status = 0, $created_at = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->total_price = $total_price;
        $this->status = $status;
        $this->created_at = $created_at;
    }

    // Getters and Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getTotalPrice() { return $this->total_price; }
    public function setTotalPrice($total_price) { $this->total_price = $total_price; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

    // Method to create an order and save it to the database
    public function createOrder($pdo) {
        $sql = "INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->user_id, $this->total_price, $this->status]);

        // Get the last inserted order ID
        $this->id = $pdo->lastInsertId();
        return $this->id;
    }

    // Method to add items to an order
    public function addOrderItems($pdo, $cart) {
        // Loop through the cart and add each item to the order_items table
        foreach ($cart as $guitarId => $item) {
            $sql = "INSERT INTO order_items (order_id, guitar_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id, $guitarId, $item['quantity'], $item['price']]);
        }
    }

    // Method to update the status of an order (e.g., from Pending to Completed)
    public function updateStatus($pdo, $status) {
        $this->status = $status;
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->status, $this->id]);
    }

    // Method to get all orders for a specific user
    public static function getUserOrders($pdo, $user_id) {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a specific order by its ID
    public static function getOrderById($pdo, $order_id) {
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to get all items for a specific order
    public static function getOrderItems($pdo, $order_id) {
        $sql = "SELECT oi.*, g.name FROM order_items oi JOIN guitars g ON oi.guitar_id = g.id WHERE oi.order_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
