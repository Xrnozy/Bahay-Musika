<?php
session_start();
include 'content-manager/db-connection.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['verify_id'])) {
    $verify_id = intval($_POST['verify_id']);
    $admin_id = $_SESSION['admin_id'] ?? null;
    if ($admin_id && $verify_id) {
        $stmt = $conn->prepare("UPDATE donations SET status = 'verified', verified_by = ?, verified_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $admin_id, $verify_id);
        $stmt->execute();
        $stmt->close();
        echo "<script>window.close();</script>";
        exit;
    } else {
        echo "<span style='color:red;'>Invalid admin session or donation ID.</span>";
        echo "<script>setTimeout(function(){window.close();}, 1500);</script>";
        exit;
    }
} else {
    echo "<span style='color:red;'>Invalid request.</span>";
    echo "<script>setTimeout(function(){window.close();}, 1500);</script>";
    exit;
}
