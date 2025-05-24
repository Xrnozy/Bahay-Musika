<?php
// Database connection for Bahay Musika App-old
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'my_database';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Set charset to utf8mb4 for better character support
$conn->set_charset("utf8mb4");
