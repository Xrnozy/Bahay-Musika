<?php
include '../../Admin/content-manager/db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['FirstName'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $comment = trim($_POST['Comment'] ?? '');
    $phone = trim($_POST['PhoneNumber'] ?? '');
    $page = 'contacts';
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if (empty($name) || empty($email) || empty($comment) || empty($phone)) {
        header('Location: thankyou.php?status=error');
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO comments (name, email, comment, page, ip_address, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $name, $email, $comment, $page, $ip);

    if ($stmt->execute()) {
        header('Location: thankyou.php?status=success');
        exit;
    } else {
        header('Location: thankyou.php?status=error');
        exit;
    }
} else {
    header('Location: thankyou.php?status=error');
    exit;
}
