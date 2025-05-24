<?php
include 'db-connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT title, location, DATE_FORMAT(date, '%Y-%m-%d') as date, time, fb_link, image, image_type, created_at, updated_at FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        echo json_encode($event);
    } else {
        echo json_encode(['error' => 'Event not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
