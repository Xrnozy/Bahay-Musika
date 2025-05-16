<div id="content" class="dashboard">
    <h3 class="dashboard-title">Homepage Manager</h3>
    <div>
        <?php
        include 'db-connection.php';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (empty($name) || empty($email)) {
                echo "<p style='color: red;'>❌ Name and Email are required.</p>";
                exit;
            }


            $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                echo "<p style='color: orange;'>⚠️ User with this email already exists.</p>";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ss", $name, $email);
                    if ($stmt->execute()) {
                        echo "<p style='color: green;'>✅ New user added successfully!</p>";
                    } else {
                        echo "<p style='color: red;'>❌ Insert Error: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p style='color: red;'>❌ Prepare Failed: " . $conn->error . "</p>";
                }
            }

            $check->close();
            $conn->close();
            exit;
        }
        ?>


        <form id="userForm">
            <label>Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <input type="submit" value="Submit">
        </form>

        <div id="form-response" style="margin-top: 10px;"></div>
    </div>

</div>