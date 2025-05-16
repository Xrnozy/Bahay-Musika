<?php
// File: content-manager/update_member.php

include 'db-connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p style='color:red;'>Invalid member ID.</p>";
    exit;
}

<<<<<<< HEAD
=======
$conn = new mysqli("127.0.0.1", "root", "", "my_database", 3307);
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

$stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<p style='color:red;'>Member not found.</p>";
    exit;
}
?>

<form id="editMemberForm">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
    <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"></label><br>
    <label>Facebook Link: <input type="text" name="fb_link"
            value="<?= htmlspecialchars($user['fb_link']) ?>"></label><br>
    <label>Category: <input type="text" name="category" value="<?= htmlspecialchars($user['category']) ?>"></label><br>
    <button type="submit">Save Changes</button>
</form>
<div id="edit-response"></div>

<script>
document.getElementById("editMemberForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);

<<<<<<< HEAD
        fetch("content-manager/update_member_process.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                document.getElementById("edit-response").innerHTML = data;
            })
            .catch(err => {
                document.getElementById("edit-response").innerHTML =
                    "<p style='color:red;'>Error saving changes.</p>";
            });
    });
=======
    fetch("content-manager/update_member_process.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            document.getElementById("edit-response").innerHTML = data;
        })
        .catch(err => {
            document.getElementById("edit-response").innerHTML =
                "<p style='color:red;'>Error saving changes.</p>";
        });
});
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
</script>