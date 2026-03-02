<?php
// Database connection
$host = 'localhost'; // or the host your MySQL server is on
$username = 'root'; // your MySQL username
$password = ''; // your MySQL password
$database = 'salary_calculator'; // your database name
$port = 3307; // MySQL Port

// Create a connection
$conn = new mysqli($host, $username, $password, $database, $port); // Include the port here

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";
?>