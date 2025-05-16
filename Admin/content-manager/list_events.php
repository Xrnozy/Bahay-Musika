<?php
// File: list_events.php

<<<<<<< HEAD
include 'db-connection.php';
=======
$conn = new mysqli("127.0.0.1", "root", "", "my_database", 3307);
if ($conn->connect_error) {
    exit("<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
}
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670

$result = $conn->query("SELECT id, title, location, date, time, fb_link FROM events ORDER BY id DESC");
?>

<div class="events-list">
    <h2 class="events-title">List of Events</h2>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Facebook Link</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['time']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['fb_link']); ?>" target="_blank">View</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No events available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>