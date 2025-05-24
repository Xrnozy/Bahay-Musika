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
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    $errors = [];

    if (empty($name)) {
        $errors[] = 'Name is required';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }

    if (empty($message)) {
        $errors[] = 'Message is required';
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    // Insert contact record
    $stmt = $conn->prepare("
        INSERT INTO contacts (name, email, phone, subject, message, status) 
        VALUES (?, ?, ?, ?, ?, 'new')
    ");

    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        $contact_id = $conn->insert_id;

        // Send confirmation email (optional - you can implement this later)
        // sendContactConfirmationEmail($email, $name, $subject);

        echo json_encode([
            'success' => true,
            'message' => 'Your message has been sent successfully! We will get back to you soon.',
            'contact_id' => $contact_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send message']);
    }
} catch (Exception $e) {
    error_log("Contact processing error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while sending your message']);
}

function sendContactConfirmationEmail($email, $name, $subject)
{
    // Email configuration - implement this based on your email service
    $emailSubject = "Contact Form Confirmation - Bahay Musika";
    $emailMessage = "
    Dear $name,
    
    Thank you for contacting Bahay Musika.
    
    We have received your message with the subject: '$subject'
    
    Our team will review your message and get back to you as soon as possible.
    
    Best regards,
    Bahay Musika Team
    ";

    $headers = "From: noreply@bahaymusika.com\r\n";
    $headers .= "Reply-To: info@bahaymusika.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Uncomment to enable email sending
    // mail($email, $emailSubject, $emailMessage, $headers);
}
