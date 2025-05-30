<?php
session_start();
include 'db-connection.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['verify_id'])) {
    $verify_id = intval($_POST['verify_id']);
    // Get the current admin ID from the session
    $admin_id = $_SESSION['user_id'] ?? null;
    if ($admin_id && $verify_id) {
        $stmt = $conn->prepare("UPDATE donations SET status = 'verified', verified_by = ?, verified_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $admin_id, $verify_id);
        $stmt->execute();
        $stmt->close();
        echo "<script>window.close();</script>";
        exit;
    } else {
        echo "<span style='color:red;'>Invalid admin session or donation ID.</span>";
        echo "<script>setTimeout(function(){window.close();}, 100);</script>";
        exit;
    }
} else {
    echo "<span style='color:red;'>Invalid request.</span>";
    echo "<script>setTimeout(function(){window.close();}, 100);</script>";
    exit;
}
