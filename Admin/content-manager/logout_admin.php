<?php
// content-manager/logout_admin.php
session_start();
require_once '../lib/Db_connection.php';
require_once '../lib/Auth.php';

$auth = new Auth($conn);
$currentUser = $auth->getCurrentUser();
if ($currentUser['role'] !== 'head_admin') {
    http_response_code(403);
    echo 'Access denied.';
    exit;
}

if (!isset($_POST['session_id'])) {
    http_response_code(400);
    echo 'Missing session_id.';
    exit;
}
$sessionId = $_POST['session_id'];
// Remove session from DB (you must implement this logic in your backend)
$stmt = $conn->prepare('DELETE FROM admin_sessions WHERE session_id = ?');
$stmt->bind_param('s', $sessionId);
if ($stmt->execute()) {
    echo 'Admin logged out.';
} else {
    echo 'Failed to logout admin.';
}
