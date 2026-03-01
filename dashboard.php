<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit;
}

echo "Welcome, " . $_SESSION['username'];
?>