<?php
require_once 'lib/Db_connection.php';

// Create default admin users
$users = [
    [
        'username' => 'admin',
        'email' => 'admin@bahaymusika.com',
        'password' => '123',
        'role' => 'head_admin',
        'first_name' => 'Head',
        'last_name' => 'Administrator'
    ],
    [
        'username' => 'content_manager',
        'email' => 'content@bahaymusika.com',
        'password' => '123',
        'role' => 'content_manager',
        'first_name' => 'Content',
        'last_name' => 'Manager'
    ],
    [
        'username' => 'social_manager',
        'email' => 'social@bahaymusika.com',
        'password' => '123',
        'role' => 'social_manager',
        'first_name' => 'Social',
        'last_name' => 'Manager'
    ]
];

echo "<h2>Setting up admin users...</h2>";

foreach ($users as $user) {
    // Check if user already exists
    $check_stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ? OR email = ?");
    $check_stmt->bind_param("ss", $user['username'], $user['email']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p>User '{$user['username']}' already exists. Updating password...</p>";

        // Update existing user
        $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE admin_users SET password = ?, role = ?, first_name = ?, last_name = ?, status = 'active' WHERE username = ?");
        $update_stmt->bind_param("sssss", $hashed_password, $user['role'], $user['first_name'], $user['last_name'], $user['username']);

        if ($update_stmt->execute()) {
            echo "<p style='color: green;'>✓ Updated user '{$user['username']}'</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to update user '{$user['username']}'</p>";
        }
    } else {
        // Create new user
        $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
        $insert_stmt = $conn->prepare("INSERT INTO admin_users (username, email, password, role, first_name, last_name, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
        $insert_stmt->bind_param("ssssss", $user['username'], $user['email'], $hashed_password, $user['role'], $user['first_name'], $user['last_name']);

        if ($insert_stmt->execute()) {
            echo "<p style='color: green;'>✓ Created user '{$user['username']}'</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to create user '{$user['username']}'</p>";
        }
    }
}

echo "<h3>Setup Complete!</h3>";
echo "<p>You can now login with:</p>";
echo "<ul>";
echo "<li><strong>admin</strong> / 123 (Head Admin)</li>";
echo "<li><strong>content_manager</strong> / 123 (Content Manager)</li>";
echo "<li><strong>social_manager</strong> / 123 (Social Manager)</li>";
echo "</ul>";
echo "<p><a href='login.php'>Go to Login Page</a></p>";
