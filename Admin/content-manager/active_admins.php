<?php
// Only head admin can access this page
session_start();
require_once '../lib/Db_connection.php';
require_once '../lib/Auth.php';
$auth = new Auth($conn);
$currentUser = $auth->getCurrentUser();
if (!$currentUser || $currentUser['role'] !== 'head_admin') {
    echo '<div class="alert alert-danger">Access denied. Only head admin can view this page.</div>';
    exit;
}
// Fetch all admins except head admin
$admins = [];
$sql = "SELECT id, username, role, is_blocked FROM admin_users WHERE role != 'head_admin'";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}
?>

<style>
    #content {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container-1 {
        max-width: 40rem;
        display: flex;
        flex-direction: column;
    }
</style>
<div class="container-1 mt-3">

    <h3>Manage Admin Accounts</h3>
    <table class="table table-bordered table-striped" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.07);border-radius:10px;overflow:hidden;max-width:700px;margin:auto;">
        <thead style="background:#4e73df;color:#fff;">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['username']) ?></td>
                    <td><?= htmlspecialchars($admin['role']) ?></td>
                    <td>
                        <?php if ($admin['is_blocked']): ?>
                            <span style="color:red;font-weight:600;">Blocked</span>
                        <?php else: ?>
                            <span style="color:green;font-weight:600;">Active</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($admin['is_blocked']): ?>
                            <button class="btn btn-success btn-sm" onclick="toggleBlock(<?= $admin['id'] ?>, 0)">Unblock</button>
                        <?php else: ?>
                            <button class="btn btn-danger btn-sm" onclick="toggleBlock(<?= $admin['id'] ?>, 1)">Block</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    function toggleBlock(adminId, block) {
        const action = block ? 'block' : 'unblock';
        if (!confirm(`Are you sure you want to ${action} this admin?`)) return;
        fetch('content-manager/block_admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${adminId}&block=${block}`
            })
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                location.reload();
            });
    }
</script>