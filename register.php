<?php
session_start();
require 'db_connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username or Email already exists!";
        header("Location: register.html");
        exit;
    }

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: login.html"); // Redirect to login page after successful registration
    } else {
        $_SESSION['error'] = "Error registering user.";
        header("Location: register.html");
    }
}
?>