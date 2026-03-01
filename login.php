<?php
session_start();
require 'db_connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Email not found!";
        header("Location: login.html");
        exit;
    }

    $user = $result->fetch_assoc();
    // Verify the password
    if (password_verify($password, $user['password'])) {
        $_SESSION['userID'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // Redirect to a dashboard page after successful login
    } else {
        $_SESSION['error'] = "Incorrect password!";
        header("Location: login.html");
    }
}
?>