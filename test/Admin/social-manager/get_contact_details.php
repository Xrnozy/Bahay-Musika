<?php
session_start();
require_once '../lib/Db_connection.php';
require_once '../lib/Auth.php';

// Initialize Auth with database connection
$auth = new Auth($conn);

// Check if user is logged in and has social manager role
if (!$auth->isAuthenticated() || !$auth->canViewComments()) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get contact ID
$contact_id = (int)($_GET['id'] ?? 0);

if (!$contact_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid contact ID']);
    exit;
}

// Fetch contact details
$query = "SELECT c.*, u.username as processed_by_name 
          FROM contacts c 
          LEFT JOIN admin_users u ON c.processed_by = u.id 
          WHERE c.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $contact_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Contact not found']);
    exit;
}

$contact = $result->fetch_assoc();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($contact);
