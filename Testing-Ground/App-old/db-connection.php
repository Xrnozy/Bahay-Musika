<?php
// Database connection for content-manager scripts
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'my_database';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
