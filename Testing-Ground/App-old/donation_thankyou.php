<?php
require_once 'db-connection.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thank You for Your Donation</title>
    <link rel="stylesheet" href="main-css.css">
    <style>
        .thankyou-container {
            text-align: center;
            padding: 50px;
            max-width: 800px;
            margin: 100px auto;
            background-color: #1f1f1f;
            border-radius: 10px;
        }

        .thankyou-message {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="thankyou-container">
        <div class="thankyou-message">
            Thank you for supporting Bahay Musika!
        </div>
        <p>Your donation helps us continue our mission.</p>
        <?php
        if (isset($_GET['donation_type'])) {
            $type = $_GET['donation_type'] === 'monthly' ? 'Monthly Supporter' : 'One-Time Donor';
            echo '<p style="color:#ffd600;font-size:1.2em;margin-bottom:20px;">Donation Type: <b>' . htmlspecialchars($type) . '</b></p>';
        }
        ?>
        <a href="home.php" class="continue-button">Return Home</a>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>