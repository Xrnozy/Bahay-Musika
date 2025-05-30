<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10;url=contacts.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f7f7f7;
            font-family: 'Montserrat', Arial, sans-serif;
        }

        .thankyou-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 48px 32px;
            text-align: center;
            max-width: 400px;
        }

        .thankyou-container h1 {
            color: #1a237e;
            margin-bottom: 16px;
            font-size: 2.2rem;
        }

        .thankyou-container p {
            color: #444;
            font-size: 1.1rem;
            margin-bottom: 24px;
        }

        .thankyou-container .countdown {
            color: #888;
            font-size: 1rem;
        }
    </style>
    <script>
        let seconds = 10;

        function updateCountdown() {
            document.getElementById('countdown').textContent = seconds;
            if (seconds > 0) {
                seconds--;
                setTimeout(updateCountdown, 1000);
            }
        }
        window.onload = updateCountdown;
    </script>
</head>

<body>
    <div class="thankyou-container">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <h1>Thank You!</h1>
            <p>Your message has been received. We appreciate your feedback and will get back to you soon.</p>
        <?php else: ?>
            <h1>Submission Failed</h1>
            <p>There was a problem with your submission. Please try again.</p>
        <?php endif; ?>
        <div class="countdown">This page will close in <span id="countdown">10</span> seconds...</div>
    </div>
</body>

</html>