<?php
// Database connection parameters
$servername = "localhost"; // Database server
$username = "root";        // MySQL username
$password = "";            // MySQL password (default for XAMPP)
$dbname = "adera";       // Database name

// Create a connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
