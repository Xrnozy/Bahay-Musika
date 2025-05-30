<?php
// donation_submit.php
// Handles donation form submission, hashes/encrypts sensitive data, and shows a thank you message

// Database connection (adjust as needed)
$host = 'localhost';
$db   = 'my_database';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Helper: Encrypt sensitive data (reversible)
define('ENCRYPT_KEY', 'your-32-char-secret-key-here'); // Use a strong, 32-char key
function encrypt_sensitive($data)
{
    if ($data === null || $data === '') return '';
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($data, $cipher, ENCRYPT_KEY, 0, $iv);
    return base64_encode($iv . $ciphertext);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_name = $_POST['donor_name'] ?? '';
    $donor_email = $_POST['donor_email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $reference_number = $_POST['transaction_id'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $donation_type = $_POST['donation_type'] ?? '';
    $image = null;
    $image_type = null;
    if (isset($_FILES['transaction_proof']) && $_FILES['transaction_proof']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['transaction_proof']['tmp_name']);
        $image_type = mime_content_type($_FILES['transaction_proof']['tmp_name']);
    }
    // Encrypt sensitive fields
    $enc_name = encrypt_sensitive($donor_name);
    $enc_email = encrypt_sensitive($donor_email);
    $enc_phone = encrypt_sensitive($phone);
    // Insert into database (image as BLOB)
    $stmt = $conn->prepare("INSERT INTO donations (donor_name, donor_email, phone, amount, reference_number, payment_method, donation_type, image, image_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param('sssssssss', $enc_name, $enc_email, $enc_phone, $amount, $reference_number, $payment_method, $donation_type, $image, $image_type);
    if ($image !== null) {
        $stmt->send_long_data(6, $image);
    }
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    $stmt->close();
    $conn->close();
    // Show thank you message and prevent resubmission with browser refresh/back
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Thank You for Your Donation</title>';
    echo '<link rel="stylesheet" href="donation.css">';
    echo '<style>body{font-family:Segoe UI,Arial,sans-serif;background:#f7f7f7;margin:0;padding:0;}';
    echo '.thankyou-container{max-width:500px;margin:60px auto;background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.08);padding:40px;text-align:center;}';
    echo '.thankyou-title{font-size:2.2rem;color:#181818;margin-bottom:12px;}';
    echo '.thankyou-icon{font-size:3.5rem;color:#4caf50;margin-bottom:16px;}';
    echo '.thankyou-msg{font-size:1.1rem;color:#444;margin-bottom:24px;}';
    echo '.thankyou-btn{display:inline-block;padding:12px 32px;background:#ffd600;color:#181818;border:none;border-radius:8px;font-weight:600;text-decoration:none;transition:background 0.2s;}';
    echo '.thankyou-btn:hover{background:#ffe066;}';
    echo '.receipt-box{background:#f5f5f5;border-radius:10px;padding:20px;margin:24px 0;text-align:left;box-shadow:0 2px 8px rgba(0,0,0,0.04);}';
    echo '.receipt-title{font-weight:700;font-size:1.1rem;margin-bottom:10px;color:#181818;}';
    echo '.receipt-row{margin-bottom:6px;font-size:1rem;}';
    echo '</style>';
    echo '<script>if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); }</script>';
    echo '</head><body>';
    echo '<div class="thankyou-container">';
    echo '<div class="thankyou-icon">&#x1F389;</div>';
    echo '<div class="thankyou-title">Thank You for Your Donation!</div>';
    echo '<div class="thankyou-msg">Your generosity helps us continue our mission. We truly appreciate your support.<br><br>A confirmation has been sent to your email (if provided).</div>';
    echo '<div class="receipt-box">';
    echo '<div class="receipt-title">Donation Receipt</div>';
    echo '<div class="receipt-row"><b>Receipt No.:</b> ' . htmlspecialchars($reference_number) . '</div>';
    echo '<div class="receipt-row"><b>Amount:</b> ₱' . htmlspecialchars(number_format((float)$amount, 2)) . '</div>';
    echo '<div class="receipt-row"><b>Payment Method:</b> ' . htmlspecialchars($payment_method) . '</div>';
    echo '<div class="receipt-row"><b>Donation Type:</b> ' . htmlspecialchars($donation_type === 'monthly' ? 'Monthly Supporter' : 'One-Time Donor') . '</div>';
    // Get the current date/time in Asia/Manila timezone
    date_default_timezone_set('Asia/Manila');
    $receipt_date = date('F j, Y, g:i a');
    echo '<div class="receipt-row"><b>Date:</b> ' . htmlspecialchars($receipt_date) . '</div>';
    echo '</div>';
    echo '<a class="thankyou-btn" href="donation.php">Back to Donation Page</a>';
    echo '</div></body></html>';
    exit;
}
// If not POST, redirect to donation page
header('Location: donation.php');
exit;
