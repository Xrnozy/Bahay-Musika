<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
    require_once 'db-connection.php';

    // Sanitize and validate inputs
    $name = htmlspecialchars($_POST['donor_name']);
    $email = filter_var($_POST['donor_email'], FILTER_SANITIZE_EMAIL);
    $amount = isset($_POST['custom_amount']) ? floatval($_POST['custom_amount']) : 0;
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $donation_type = 'one-time'; // Default to one-time

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Validate amount
    if ($amount <= 0) {
        die("Please enter a valid donation amount");
    }

    try {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO donations 
                            (donor_name, donor_email, amount, payment_method, donation_type, donation_date) 
                            VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $amount, $payment_method, $donation_type]);

        // Redirect to thank you page
        header("Location: donation_thankyou.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    // Redirect if accessed directly
    header("Location: donation.php");
    exit();
}
