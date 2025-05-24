<?php
session_start();
require_once '../lib/Db_connection.php';
require_once '../lib/Auth.php';

// Initialize Auth with database connection
$auth = new Auth($conn);

// Check if user is logged in and has social manager role
if (!$auth->isAuthenticated() || !$auth->canViewDonations()) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get donation ID
$donation_id = (int)($_GET['id'] ?? 0);

if (!$donation_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid donation ID']);
    exit;
}

// Fetch donation details
$query = "SELECT d.*, u.username as processed_by_name 
          FROM donations d 
          LEFT JOIN admin_users u ON d.processed_by = u.id 
          WHERE d.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $donation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Donation not found']);
    exit;
}

$donation = $result->fetch_assoc();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($donation);
