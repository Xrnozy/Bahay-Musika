<?php
include 'db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $fb_link = trim($_POST['fb_link'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $middleName = trim($_POST['middleName'] ?? '');
    $extName = trim($_POST['extName'] ?? '');
    $profession = trim($_POST['profession'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');

    // Handle profile image upload if provided
    $profileImage = $_FILES['profileImage'] ?? null;
    $profileImageData = null;
    if ($profileImage && $profileImage['tmp_name']) {
        $profileImageData = file_get_contents($profileImage['tmp_name']);
    }

    if ($id <= 0 || empty($name) || empty($fb_link)) {
        exit("<span style='color: red;'>❌ Name and Facebook Link are required.</span>");
    }

    $sql = "UPDATE members SET name=?, fb_link=?, category=?, middleName=?, extName=?, profession=?, dob=?, phone=?, street=?, city=?, state=?, zip=?, country=?";
    $params = [$name, $fb_link, $category, $middleName, $extName, $profession, $dob, $phone, $street, $city, $state, $zip, $country];
    $types = "sssssssssssss";

    if ($profileImageData !== null) {
        $sql .= ", profile_image=?";
        $params[] = $profileImageData;
        $types .= "b";
    }
    $sql .= " WHERE id=?";
    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        exit("<span style='color: red;'>❌ Prepare failed: " . $conn->error . "</span>");
    }

    // Bind parameters dynamically
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        echo "<span style='color: green;'>✅ Member updated successfully!</span>";
    } else {
        echo "<span style='color: red;'>❌ Update failed: " . $stmt->error . "</span>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

exit("<span style='color: red;'>❌ Invalid request.</span>");
