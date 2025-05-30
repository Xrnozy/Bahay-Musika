<?php
// decrypt.php
// Handles AJAX decryption for admin, for donor_email and phone fields
header('Content-Type: application/json');

// CONFIGURE THIS PASSWORD SECURELY IN PRODUCTION!
define('ADMIN_DECRYPT_PASSWORD', 'admin123'); // Change this to a secure password

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;
$type = $input['type'] ?? null;
$password = $input['password'] ?? '';

if (!$id || !$type || !$password) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters.']);
    exit;
}

if ($password !== ADMIN_DECRYPT_PASSWORD) {
    echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
    exit;
}

require_once 'db-connection.php';

// Only allow email or phone
if (!in_array($type, ['email', 'phone'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid type.']);
    exit;
}

$field = $type === 'email' ? 'donor_email' : 'phone';

// Fetch the hashed/encrypted value
$stmt = $conn->prepare("SELECT $field FROM donations WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($value);
$stmt->fetch();
$stmt->close();

// NOTE: If you used irreversible hashing, you cannot decrypt. If you used reversible encryption, decrypt here.
// For demo, just return the stored value (not real decryption!)

if (!$value) {
    echo json_encode(['success' => false, 'message' => 'No value found.']);
    exit;
}

echo json_encode(['success' => true, 'value' => $value]);
exit;
