<?php
// Guitar.php

class Guitar
{
    private $pdo;

    // Constructor to accept PDO instance
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Add new guitar to the database
    public function addGuitar($name, $price, $quantity)
    {
        $sql = "INSERT INTO guitars (name, price, quantity) VALUES (:name, :price, :quantity)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    // Update guitar in the database
    public function updateGuitar($id, $name, $price, $quantity)
    {
        $sql = "UPDATE guitars SET name = :name, price = :price, quantity = :quantity WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    // Get all guitars
    public static function getAllGuitars($pdo)
    {
        $sql = "SELECT * FROM guitars";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a specific guitar by ID
    public static function getGuitarById($pdo, $id)
    {
        $sql = "SELECT * FROM guitars WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Delete guitar from the database

    public function deleteGuitar($id)
    {
        $sql = "DELETE FROM guitars WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
