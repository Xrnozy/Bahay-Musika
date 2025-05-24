<?php
session_start();
require_once '../lib/Db_connection.php';
require_once '../lib/Auth.php';

// Initialize Auth with database connection
$auth = new Auth($conn);

// Check if user is logged in and has social manager role
if (!$auth->isAuthenticated() || !$auth->canViewDonations()) {
    header('Location: ../login.php');
    exit;
}

// Get dashboard statistics
$donationsQuery = "SELECT COUNT(*) as total, SUM(amount) as total_amount FROM donations WHERE status = 'pending'";
$donationsResult = $conn->query($donationsQuery);
$donationsStats = $donationsResult->fetch_assoc();

$contactsQuery = "SELECT COUNT(*) as total FROM contacts WHERE status = 'new'";
$contactsResult = $conn->query($contactsQuery);
$contactsStats = $contactsResult->fetch_assoc();

$commentsQuery = "SELECT COUNT(*) as total FROM comments WHERE status = 'pending'";
$commentsResult = $conn->query($commentsQuery);
$commentsStats = $commentsResult->fetch_assoc();
?>

<div class="dashboard-title">Social Manager Dashboard</div>
<div style="padding: 40px;">
    <div class="upcoming-sched">
        <div class="upcoming-main-cont">
            <div style="padding: 20px;">
                <h3 style="margin-bottom: 20px; color: #333;">Quick Stats</h3>
                <div style="margin-bottom: 15px;">
                    <strong>Pending Donations:</strong> <?php echo $donationsStats['total']; ?>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong>Pending Amount:</strong> ₱<?php echo number_format($donationsStats['total_amount'] ?? 0, 2); ?>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong>New Messages:</strong> <?php echo $contactsStats['total']; ?>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong>Pending Comments:</strong> <?php echo $commentsStats['total']; ?>
                </div>
            </div>
        </div>

        <div class="donations">
            <div style="padding: 20px;">
                <h3 style="margin-bottom: 20px; color: #333;">Recent Activity</h3>
                <div style="max-height: 400px; overflow-y: auto;">
                    <?php
                    // Get recent donations and contacts
                    $recentQuery = "
                        SELECT 'donation' as type, donor_name as name, amount, created_at 
                        FROM donations 
                        WHERE status = 'pending' 
                        UNION ALL
                        SELECT 'contact' as type, name, NULL as amount, created_at 
                        FROM contacts 
                        WHERE status = 'new'
                        ORDER BY created_at DESC 
                        LIMIT 10
                    ";
                    $recentResult = $conn->query($recentQuery);

                    if ($recentResult->num_rows > 0) {
                        while ($row = $recentResult->fetch_assoc()) {
                            echo "<div style='padding: 10px; border-bottom: 1px solid #eee; margin-bottom: 10px;'>";
                            if ($row['type'] == 'donation') {
                                echo "<div style='font-weight: bold; color: #28a745;'>New Donation</div>";
                                echo "<div>" . htmlspecialchars($row['name']) . " donated ₱" . number_format($row['amount'], 2) . "</div>";
                            } else {
                                echo "<div style='font-weight: bold; color: #17a2b8;'>New Message</div>";
                                echo "<div>" . htmlspecialchars($row['name']) . " sent a message</div>";
                            }
                            echo "<small style='color: #666;'>" . date('M j, Y g:i A', strtotime($row['created_at'])) . "</small>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p style='color: #666; text-align: center; padding: 20px;'>No recent activity.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-buttons">
        <div class="buttons-click" onclick="window.parent.loadContent('social-manager/donations_management.php')" style="cursor: pointer;">
            <h4>Manage Donations</h4>
            <p>Review and process donations</p>
        </div>
        <div class="buttons-click" onclick="window.parent.loadContent('social-manager/contacts_management.php')" style="cursor: pointer;">
            <h4>View Messages</h4>
            <p>Handle contact form submissions</p>
        </div>
        <div class="buttons-click" onclick="window.parent.loadContent('social-manager/comments_management.php')" style="cursor: pointer;">
            <h4>Moderate Comments</h4>
            <p>Review and approve comments</p>
        </div>
    </div>
</div>

<style>
    .dashboard-buttons .buttons-click:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .dashboard-buttons .buttons-click {
        transition: all 0.3s ease;
    }

    .dashboard-buttons .buttons-click h4 {
        color: #333;
        margin-bottom: 10px;
    }

    .dashboard-buttons .buttons-click p {
        color: #666;
        font-size: 14px;
        margin: 0;
    }
</style>