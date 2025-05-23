<?php
// File: edit_event.php

include 'db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($conn->connect_error) {
        echo "<script>alert('Database connection failed: " . $conn->connect_error . "');</script>";
        exit;
    }

    $action = $_POST['action'];
    $eventId = intval($_POST['event_id'] ?? 0);

    if ($action === 'delete' && $eventId > 0) {
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $eventId);
        if ($stmt->execute()) {
            echo "<script>alert('Event deleted successfully.'); window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Failed to delete event: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } elseif ($action === 'edit' && $eventId > 0) {
        $eventTitle = trim($_POST['eventTitle'] ?? '');
        $eventLocation = trim($_POST['eventLocation'] ?? '');
        $dateOfEvents = trim($_POST['dateOfEvents'] ?? '');
        $timeOfEvents = trim($_POST['timeOfEvents'] ?? '');
        $eventsLink = trim($_POST['eventsLink'] ?? '');

        if (empty($eventTitle) || empty($eventLocation) || empty($dateOfEvents) || empty($timeOfEvents) || empty($eventsLink)) {
            echo "<script>alert('All fields are required.');</script>";
        } else {
            $stmt = $conn->prepare("UPDATE events SET title = ?, location = ?, date = ?, time = ?, fb_link = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $eventTitle, $eventLocation, $dateOfEvents, $timeOfEvents, $eventsLink, $eventId);
            if ($stmt->execute()) {
                echo "<script>alert('Event updated successfully.'); window.location.href = window.location.href;</script>";
            } else {
                echo "<script>alert('Failed to update event: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Invalid action or event ID.');</script>";
    }

    $conn->close();
    exit;
}


if ($conn->connect_error) {
    exit("<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
}

$result = $conn->query("SELECT id, title, location, date, time, fb_link FROM events ORDER BY id DESC");
?>

<div class="events-list">
    <h2 class="events-title">Edit or Delete Events</h2>
    <div class="list">
        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>
                <form method="POST" class="event-item">
                    <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                    <div class="event-details">
                        <input type="text" name="eventTitle" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                        <input type="text" name="eventLocation" value="<?php echo htmlspecialchars($row['location']); ?>"
                            required>
                        <input type="date" name="dateOfEvents" value="<?php echo htmlspecialchars($row['date']); ?>" required>
                        <input type="time" name="timeOfEvents" value="<?php echo htmlspecialchars($row['time']); ?>" required>
                        <input type="text" name="eventsLink" value="<?php echo htmlspecialchars($row['fb_link']); ?>" required>
                    </div>
                    <div class="event-actions">
                        <button type="submit" name="action" value="edit">Edit</button>
                        <button type="submit" name="action" value="delete">Delete</button>
                    </div>
                </form>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No events available.</p>
        <?php endif; ?>
    </div>
</div>

<?php $conn->close(); ?>