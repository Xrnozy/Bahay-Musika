<?php
// content-manager/ban_user_agent.php
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
if (!isset($_POST['username'], $_POST['user_agent'])) {
    http_response_code(400);
    echo 'Missing parameters.';
    exit;
}
$username = $_POST['username'];
$userAgent = $_POST['user_agent'];
// Insert banned user_agent (implement this logic in your backend)
$stmt = $conn->prepare('INSERT INTO banned_user_agents (username, user_agent) VALUES (?, ?)');
$stmt->bind_param('ss', $username, $userAgent);
if ($stmt->execute()) {
    echo 'User agent banned.';
} else {
    echo 'Failed to ban user agent.';
}
