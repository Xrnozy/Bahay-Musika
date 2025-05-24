<?php
session_start();
require_once '../lib/Db_connection.php';
require_once '../lib/Auth.php';

// Initialize Auth with database connection
$auth = new Auth($conn);

// Check if user is logged in and has social manager role
if (!$auth->isAuthenticated() || !$auth->canViewComments()) {
    header('Location: ../login.php');
    exit;
}

// Handle status updates
if ($_POST && isset($_POST['action'])) {
    $contact_id = (int)$_POST['contact_id'];
    $action = $_POST['action'];

    if ($action === 'mark_read') {
        $stmt = $conn->prepare("UPDATE contacts SET status = 'read', processed_by = ?, processed_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $contact_id);
        $stmt->execute();
        $message = "Message marked as read!";
    } elseif ($action === 'mark_resolved') {
        $response = $_POST['response'] ?? '';
        $stmt = $conn->prepare("UPDATE contacts SET status = 'resolved', processed_by = ?, processed_at = NOW(), admin_response = ? WHERE id = ?");
        $stmt->bind_param("isi", $_SESSION['user_id'], $response, $contact_id);
        $stmt->execute();
        $message = "Message marked as resolved!";
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
    $where_conditions[] = "(name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $param_types .= 'ssss';
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

$query = "SELECT c.*, u.username as processed_by_name 
          FROM contacts c 
          LEFT JOIN admin_users u ON c.processed_by = u.id 
          $where_clause 
          ORDER BY c.created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$contacts = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts Management - Bahay Musika</title>
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

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .contacts-table {
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

        .status-new {
            background: #fff3cd;
            color: #856404;
        }

        .status-read {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-resolved {
            background: #d4edda;
            color: #155724;
        }

        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
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

        .contact-details {
            line-height: 1.6;
        }

        .contact-details p {
            margin-bottom: 10px;
        }

        .contact-details strong {
            color: #333;
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
            <h1>Contacts Management</h1>
            <p>Review and respond to contact form submissions</p>
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
                        <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                        <option value="resolved" <?php echo $status_filter === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
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
                    <input type="text" name="search" placeholder="Name, email, subject..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="contacts-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Contact</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($contact = $contacts->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('M j, Y', strtotime($contact['created_at'])); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($contact['name']); ?></strong><br>
                                <small><?php echo htmlspecialchars($contact['email']); ?></small>
                                <?php if ($contact['phone']): ?>
                                    <br><small><?php echo htmlspecialchars($contact['phone']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                            <td>
                                <div class="message-preview">
                                    <?php echo htmlspecialchars(substr($contact['message'], 0, 100)); ?>
                                    <?php if (strlen($contact['message']) > 100): ?>...<?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $contact['status']; ?>">
                                    <?php echo ucfirst($contact['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info" onclick="viewContact(<?php echo $contact['id']; ?>)">View</button>
                                <?php if ($contact['status'] === 'new'): ?>
                                    <button class="btn btn-warning" onclick="markAsRead(<?php echo $contact['id']; ?>)">Mark Read</button>
                                <?php endif; ?>
                                <?php if ($contact['status'] !== 'resolved'): ?>
                                    <button class="btn btn-success" onclick="resolveContact(<?php echo $contact['id']; ?>)">Resolve</button>
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
            <h2>Contact Details</h2>
            <div id="contactDetails" class="contact-details"></div>
        </div>
    </div>

    <!-- Resolve Modal -->
    <div id="resolveModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Resolve Contact</h2>
            <form method="POST">
                <input type="hidden" name="action" value="mark_resolved">
                <input type="hidden" name="contact_id" id="resolveContactId">
                <div class="filter-group">
                    <label>Response/Notes (optional):</label>
                    <textarea name="response" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;" placeholder="Add any notes about how this was resolved..."></textarea>
                </div>
                <div style="margin-top: 15px;">
                    <button type="submit" class="btn btn-success">Mark as Resolved</button>
                    <button type="button" class="btn" onclick="closeModal('resolveModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function viewContact(id) {
            // Fetch contact details via AJAX
            fetch(`get_contact_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('contactDetails').innerHTML = `
                        <p><strong>Name:</strong> ${data.name}</p>
                        <p><strong>Email:</strong> ${data.email}</p>
                        ${data.phone ? `<p><strong>Phone:</strong> ${data.phone}</p>` : ''}
                        <p><strong>Subject:</strong> ${data.subject}</p>
                        <p><strong>Message:</strong></p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;">
                            ${data.message.replace(/\n/g, '<br>')}
                        </div>
                        <p><strong>Date:</strong> ${new Date(data.created_at).toLocaleString()}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                        ${data.processed_by_name ? `<p><strong>Processed by:</strong> ${data.processed_by_name}</p>` : ''}
                        ${data.admin_response ? `<p><strong>Admin Response:</strong></p><div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 10px 0;">${data.admin_response.replace(/\n/g, '<br>')}</div>` : ''}
                    `;
                    document.getElementById('viewModal').style.display = 'block';
                });
        }

        function markAsRead(id) {
            if (confirm('Mark this message as read?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="mark_read">
                    <input type="hidden" name="contact_id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function resolveContact(id) {
            document.getElementById('resolveContactId').value = id;
            document.getElementById('resolveModal').style.display = 'block';
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