<?php
// block_admin.php: Block or unblock an admin (head admin only)
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
if (!isset($_POST['id'], $_POST['block'])) {
    http_response_code(400);
    echo 'Missing parameters.';
    exit;
}
$id = intval($_POST['id']);
$block = intval($_POST['block']) ? 1 : 0;
$stmt = $conn->prepare('UPDATE admin_users SET is_blocked = ? WHERE id = ? AND role != "head_admin"');
$stmt->bind_param('ii', $block, $id);
if ($stmt->execute()) {
    echo $block ? 'Admin blocked.' : 'Admin unblocked.';
} else {
    echo 'Failed to update admin status.';
}
