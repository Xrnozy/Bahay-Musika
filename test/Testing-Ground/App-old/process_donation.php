<?php
require_once 'db-connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get and validate input data
    $donor_name = trim($_POST['donor_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $reference_number = trim($_POST['reference_number'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');
    $donation_type = trim($_POST['donation_type'] ?? 'one_time');
    $message = trim($_POST['message'] ?? '');

    // Validation
    $errors = [];

    if (empty($donor_name)) {
        $errors[] = 'Donor name is required';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    if ($amount < 20) {
        $errors[] = 'Minimum donation amount is ₱20';
    }

    if (empty($reference_number)) {
        $errors[] = 'Reference number is required';
    }

    if (!in_array($payment_method, ['gcash', 'bpi', 'bank_transfer', 'other'])) {
        $errors[] = 'Invalid payment method';
    }

    if (!in_array($donation_type, ['one_time', 'monthly'])) {
        $errors[] = 'Invalid donation type';
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    // Check if reference number already exists
    $stmt = $conn->prepare("SELECT id FROM donations WHERE reference_number = ?");
    $stmt->bind_param("s", $reference_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Reference number already exists']);
        exit;
    }

    // Insert donation record
    $stmt = $conn->prepare("
        INSERT INTO donations (donor_name, email, phone, amount, reference_number, payment_method, donation_type, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->bind_param("sssdssss", $donor_name, $email, $phone, $amount, $reference_number, $payment_method, $donation_type, $message);

    if ($stmt->execute()) {
        $donation_id = $conn->insert_id;

        // Send confirmation email (optional - you can implement this later)
        // sendDonationConfirmationEmail($email, $donor_name, $amount, $reference_number);

        echo json_encode([
            'success' => true,
            'message' => 'Donation submitted successfully! Your donation is pending verification.',
            'donation_id' => $donation_id,
            'reference_number' => $reference_number
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to process donation']);
    }
} catch (Exception $e) {
    error_log("Donation processing error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your donation']);
}

function sendDonationConfirmationEmail($email, $name, $amount, $reference)
{
    // Email configuration - implement this based on your email service
    $subject = "Donation Confirmation - Bahay Musika";
    $message = "
    Dear $name,
    
    Thank you for your generous donation of ₱" . number_format($amount, 2) . " to Bahay Musika.
    
    Your donation details:
    - Reference Number: $reference
    - Amount: ₱" . number_format($amount, 2) . "
    - Status: Pending Verification
    
    We will verify your donation and update you once confirmed.
    
    Best regards,
    Bahay Musika Team
    ";

    $headers = "From: noreply@bahaymusika.com\r\n";
    $headers .= "Reply-To: info@bahaymusika.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Uncomment to enable email sending
    // mail($email, $subject, $message, $headers);
}
