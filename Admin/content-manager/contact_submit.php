<?php
include 'db-connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $number = trim($_POST['number'] ?? '');

    // Validate required fields
    $missing = [];
    if (empty($name)) $missing[] = 'Name';
    if (empty($email)) $missing[] = 'Email';
    if (empty($number)) $missing[] = 'Number';

    if (!empty($missing)) {
        $msg = "<span style='color: red;'>❌ Please fill in all required fields: " . implode(', ', $missing) . ".</span>";
    } else {
        // Insert into database (table: contacts)
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, number) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $number);
            if ($stmt->execute()) {
                $msg = "<span style='color: green;'>✅ Thank you, $name! Your information has been submitted successfully.</span>";
            } else {
                $msg = "<span style='color: red;'>❌ Database error: " . $stmt->error . "</span>";
            }
            $stmt->close();
        } else {
            $msg = "<span style='color: red;'>❌ Prepare failed: " . $conn->error . "</span>";
        }
    }
    $conn->close();
} else {
    $msg = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Submission - Bahay Musika</title>
    <link rel="stylesheet" href="../css/contact_submit.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f7f7f9;
            margin: 0;
        }

        .container {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 36px 32px;
            text-align: center;
        }

        h1 {
            color: #2a3b4c;
            margin-bottom: 12px;
        }

        .thankyou-icon {
            font-size: 48px;
            color: #4caf50;
            margin-bottom: 12px;
        }

        .info {
            margin: 18px 0 0 0;
            color: #444;
            font-size: 1.1em;
        }

        .back-btn {
            margin-top: 32px;
            background: #2a3b4c;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 28px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #1a2533;
        }

        .msg {
            margin: 18px 0 0 0;
            font-size: 1.1em;
        }

        @media (max-width: 600px) {
            .container {
                padding: 18px 6vw;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="thankyou-icon">🎶</div>
        <h1>Thank You!</h1>
        <?php if (isset($msg)) {
            echo "<div class='msg'>$msg</div>";
        } ?>
        <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($missing)) { ?>
            <div class="info">
                <strong>Name:</strong> <?php echo htmlspecialchars($name); ?><br>
                <strong>Email:</strong> <?php echo htmlspecialchars($email); ?><br>
                <strong>Number:</strong> <?php echo htmlspecialchars($number); ?>
            </div>
        <?php } ?>
        <button class="back-btn" onclick="window.location.href='add_member.php'">Back to Add Member</button>
    </div>
</body>

</html>