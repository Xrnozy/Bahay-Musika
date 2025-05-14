<?php
// Database connection file
$conn = new mysqli("127.0.0.1", "root", "", "my_database");
if ($conn->connect_error) {
    exit("<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
}