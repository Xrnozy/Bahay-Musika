<?php
include '../db-connection.php';

// Fetch recent comments (use correct columns from DB)
$recentComments = $conn->query("SELECT name, email, comment, page, created_at FROM comments ORDER BY created_at DESC LIMIT 5");

// Fetch recent donations (use correct columns from DB)
$recentDonations = $conn->query("SELECT donor_name, email, phone, amount, payment_method, donation_type, created_at FROM donations ORDER BY created_at DESC LIMIT 5");

$conn->close();
?>


<link rel="stylesheet" href="../Admin.css">
<link rel="stylesheet" href="css/dashboard_management.css">
<div id="content" class="dashboard">
    <style>
        .first-container {
            display: flex;
            flex-direction: column;

        }

        .first-container .top-container {
            justify-content: flex-start;
        }

        .top-container {
            display: flex;
            flex-direction: row;
            width: 100%;
            height: fit-content;
            margin-bottom: 20px;
        }

        .second-container {
            display: flex;
            flex-direction: column;
            width: auto;
            height: 100%;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            padding: 20px;
            width: 100%;
            height: fit-content;
        }
    </style>

    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Social Manager</h1>
    </div>
    <h3 class="dashboard-title">Dashboard</h3>
    <div class="main-container">
        <div class="first-container">
            <div class="top-container">
                <div class="recent-comments">
                    <h3>Recent Comments</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.07);border-radius:10px;overflow:hidden;">
                            <thead style="background:#4e73df;color:#fff;">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Comment</th>
                                    <th>Page</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($comment = $recentComments->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($comment['name']) ?></td>
                                        <td><?= htmlspecialchars($comment['email']) ?></td>
                                        <td><?= htmlspecialchars($comment['comment']) ?></td>
                                        <td><?= htmlspecialchars($comment['page']) ?></td>
                                        <td><?= date('M d, Y H:i', strtotime($comment['created_at'])) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="second-container">
            <div class="top-container">
                <div class="recent-donations">
                    <h3>Recent Donations</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.07);border-radius:10px;overflow:hidden;">
                            <thead style="background:#4e73df;color:#fff;">
                                <tr>
                                    <th>Donor Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rowCount = 0;
                                while ($donation = $recentDonations->fetch_assoc()):
                                    if ($rowCount >= 5) break;
                                    $rowCount++;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars(mb_strimwidth($donation['donor_name'], 0, 5, '...')) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($donation['email'], 0, 5, '...')) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($donation['phone'], 0, 5, '...')) ?></td>
                                        <td>₱<?= number_format($donation['amount'], 2) ?></td>
                                        <td><?= ucfirst($donation['payment_method']) ?></td>
                                        <td><?= ucfirst(str_replace('_', ' ', $donation['donation_type'])) ?></td>
                                        <td><?= date('M d, Y H:i', strtotime($donation['created_at'])) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>