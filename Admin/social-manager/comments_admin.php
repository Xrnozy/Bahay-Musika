<?php
include '../content-manager/db-connection.php';

$query = "SELECT id, name, email, comment, page, ip_address, status, created_at FROM comments ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Comments Admin</title>
    <link rel="stylesheet" href="../Admin.css">
    <style>
        body {
            background: #f7f7fa;
            font-family: 'Montserrat', Arial, sans-serif;
        }

        .comments-table {
            width: 98%;
            margin: 32px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(30, 42, 73, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 10px;
            text-align: left;
        }

        th {
            background: rgb(52, 52, 54);
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f4f6fa;
        }

        tr:hover {
            background: #e3eafc;
        }

        td {
            color: #222;
            font-size: 1rem;
        }

        .status-pending {
            color: #ff9800;
            font-weight: 600;
        }

        .status-approved {
            color: #388e3c;
            font-weight: 600;
        }

        .status-rejected {
            color: #d32f2f;
            font-weight: 600;
        }

        .status-spam {
            color: #757575;
            font-weight: 600;
        }

        .reply-btn {
            display: inline-block;
            background: #1a73e8;
            color: #fff;
            padding: 7px 16px;
            border-radius: 5px;
            font-size: 0.98rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
            margin-top: 2px;
        }

        .reply-btn:hover {
            background: #0b57d0;
        }
    </style>
</head>

<body>
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Feedback Overview</h3>
    <div class="comments-table">
        <h2 style="padding: 18px 0 0 18px; color: #1a237e;">Comments Table</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Comment</th>
                    <th>Page</th>
                    <th>Created At</th>
                    <th>Reply</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['comment'])); ?></td>
                            <td><?php echo htmlspecialchars($row['page']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($row['email']); ?>&su=Reply%20to%20your%20comment%20on%20Bahay%20Musika" target="_blank" class="reply-btn">Reply via Gmail</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; color:#888;">No comments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>