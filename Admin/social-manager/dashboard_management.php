<?php
include 'db-connection.php';

// Fetch recent comments
$recentComments = $conn->query("SELECT * FROM comments ORDER BY created_at DESC LIMIT 5");

// Fetch recent donations
$recentDonations = $conn->query("SELECT * FROM donations ORDER BY created_at DESC LIMIT 5");

$conn->close();
?>


<link rel="stylesheet" href="../Admin.css">
<link rel="stylesheet" href="css/dashboard_management.css">
<div id="content" class="dashboard">
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Social Manager</h1>
    </div>
    <h3 class="dashboard-title">Dashboard</h3>
    <div class="main-container">
        <div class="first-container">
            <div class="top-container">
                <div class="recent-comments">
                    <h3>Recent Comments</h3>
                    <ul>
                        <?php while ($comment = $recentComments->fetch_assoc()): ?>
                            <li>
                                <strong><?= htmlspecialchars($comment['author']) ?>:</strong>
                                <?= htmlspecialchars($comment['content']) ?>
                                <em>(<?= $comment['created_at'] ?>)</em>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="second-container">
            <div class="top-container">
                <div class="recent-donations">
                    <h3>Recent Donations</h3>
                    <ul>
                        <?php while ($donation = $recentDonations->fetch_assoc()): ?>
                            <li>
                                <strong><?= htmlspecialchars($donation['donor_name']) ?>:</strong>
                                $<?= htmlspecialchars($donation['amount']) ?>
                                <em>(<?= $donation['created_at'] ?>)</em>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>