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

// Handle status updates
if ($_POST && isset($_POST['action'])) {
    $donation_id = (int)$_POST['donation_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE donations SET status = 'approved', processed_by = ?, processed_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $donation_id);
        $stmt->execute();
        $message = "Donation approved successfully!";
    } elseif ($action === 'reject') {
        $reason = $_POST['reason'] ?? '';
        $stmt = $conn->prepare("UPDATE donations SET status = 'rejected', processed_by = ?, processed_at = NOW(), rejection_reason = ? WHERE id = ?");
        $stmt->bind_param("isi", $_SESSION['user_id'], $reason, $donation_id);
        $stmt->execute();
        $message = "Donation rejected successfully!";
    }
}

// Get filter parameters
$status_filter = $_GET['status'] ?? 'all';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$where_conditions = [];
$params = [];
$param_types = '';

if ($status_filter !== 'all') {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
    $param_types .= 's';
}

if ($date_from) {
    $where_conditions[] = "DATE(created_at) >= ?";
    $params[] = $date_from;
    $param_types .= 's';
}

if ($date_to) {
    $where_conditions[] = "DATE(created_at) <= ?";
    $params[] = $date_to;
    $param_types .= 's';
}

if ($search) {
    $where_conditions[] = "(donor_name LIKE ? OR email LIKE ? OR reference_number LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $param_types .= 'sss';
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

$query = "SELECT d.*, u.username as processed_by_name 
          FROM donations d 
          LEFT JOIN admin_users u ON d.processed_by = u.id 
          $where_clause 
          ORDER BY d.created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$donations = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations Management - Bahay Musika</title>
    <link rel="stylesheet" href="../main-css.css">
    <style>
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .filter-group input,
        .filter-group select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a6fd8;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .donations-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .nav-menu {
            background: #333;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .nav-menu ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .nav-menu li {
            margin: 0 15px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .nav-menu a:hover {
            background: #555;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</head>

<body>
    <nav class="nav-menu">
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="donations_management.php">Donations</a></li>
            <li><a href="contacts_management.php">Contacts</a></li>
            <li><a href="comments_management.php">Comments</a></li>
            <li><a href="analytics.php">Analytics</a></li>
            <li><a href="../login.php?logout=1">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Donations Management</h1>
            <p>Review and manage donation submissions</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="filters">
            <form method="GET" class="filter-row">
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                        <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="approved" <?php echo $status_filter === 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo $status_filter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>From Date</label>
                    <input type="date" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
                </div>
                <div class="filter-group">
                    <label>To Date</label>
                    <input type="date" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
                </div>
                <div class="filter-group">
                    <label>Search</label>
                    <input type="text" name="search" placeholder="Name, email, reference..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="donations-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($donation = $donations->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('M j, Y', strtotime($donation['created_at'])); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($donation['donor_name']); ?></strong><br>
                                <small><?php echo htmlspecialchars($donation['email']); ?></small>
                            </td>
                            <td>₱<?php echo number_format($donation['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($donation['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($donation['reference_number']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $donation['status']; ?>">
                                    <?php echo ucfirst($donation['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info" onclick="viewDonation(<?php echo $donation['id']; ?>)">View</button>
                                <?php if ($donation['status'] === 'pending'): ?>
                                    <button class="btn btn-success" onclick="approveDonation(<?php echo $donation['id']; ?>)">Approve</button>
                                    <button class="btn btn-danger" onclick="rejectDonation(<?php echo $donation['id']; ?>)">Reject</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Donation Details</h2>
            <div id="donationDetails"></div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reject Donation</h2>
            <form method="POST">
                <input type="hidden" name="action" value="reject">
                <input type="hidden" name="donation_id" id="rejectDonationId">
                <div class="filter-group">
                    <label>Reason for rejection:</label>
                    <textarea name="reason" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;" required></textarea>
                </div>
                <div style="margin-top: 15px;">
                    <button type="submit" class="btn btn-danger">Reject Donation</button>
                    <button type="button" class="btn" onclick="closeModal('rejectModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function viewDonation(id) {
            // Fetch donation details via AJAX
            fetch(`get_donation_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('donationDetails').innerHTML = `
                        <p><strong>Donor:</strong> ${data.donor_name}</p>
                        <p><strong>Email:</strong> ${data.email}</p>
                        <p><strong>Phone:</strong> ${data.phone || 'N/A'}</p>
                        <p><strong>Amount:</strong> ₱${parseFloat(data.amount).toLocaleString()}</p>
                        <p><strong>Payment Method:</strong> ${data.payment_method}</p>
                        <p><strong>Reference Number:</strong> ${data.reference_number}</p>
                        <p><strong>Donation Type:</strong> ${data.donation_type}</p>
                        <p><strong>Message:</strong> ${data.message || 'N/A'}</p>
                        <p><strong>Date:</strong> ${new Date(data.created_at).toLocaleString()}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                        ${data.processed_by_name ? `<p><strong>Processed by:</strong> ${data.processed_by_name}</p>` : ''}
                        ${data.rejection_reason ? `<p><strong>Rejection Reason:</strong> ${data.rejection_reason}</p>` : ''}
                    `;
                    document.getElementById('viewModal').style.display = 'block';
                });
        }

        function approveDonation(id) {
            if (confirm('Are you sure you want to approve this donation?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="donation_id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function rejectDonation(id) {
            document.getElementById('rejectDonationId').value = id;
            document.getElementById('rejectModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // Close modals with X button
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.onclick = function() {
                this.closest('.modal').style.display = 'none';
            }
        });
    </script>
</body>

</html>