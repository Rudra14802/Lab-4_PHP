<?php
// User.php

class User
{
    private $pdo;

    // Constructor to accept the PDO instance
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Login function to authenticate the user
    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql); // Ensure $pdo is a PDO object
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if password matches using password_verify() for hashed passwords
        if ($user && password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }

    // Register a new user (store username and password in the database)
    public function register($username, $email,$pass)
    {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, email,password) VALUES (:username, :email,:pass)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':pass' => password_hash($pass, PASSWORD_DEFAULT) 
        ]);
    }
}
?>
