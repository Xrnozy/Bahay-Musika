<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name) || empty($email)) {
        exit("<span style='color: red;'>❌ Name and Email are required.</span>");
    }

    $conn = new mysqli("localhost", "root", "", "my_database");
    if ($conn->connect_error) {
        exit("<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        exit("<span style='color: orange;'>⚠️ User with this email already exists.</span>");
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $name, $email);
            if ($stmt->execute()) {
                exit("<span style='color: green;'>✅ New user added successfully!</span>");
            } else {
                exit("<span style='color: red;'>❌ Insert Error: " . $stmt->error . "</span>");
            }
            $stmt->close();
        } else {
            exit("<span style='color: red;'>❌ Prepare Failed: " . $conn->error . "</span>");
        }
    }

    $check->close();
    $conn->close();
}
