<?php
include 'db-connection.php';

// Get the current date
$currentDay = date('j');
$currentMonth = date('n');
$currentYear = date('Y');

// Set the calendar to May 2025
$calendarMonth = 5; // May
$calendarYear = 2025;

// Get the first day of the month and the total number of days in the month
$firstDayOfMonth = mktime(0, 0, 0, $calendarMonth, 1, $calendarYear);
$totalDaysInMonth = date('t', $firstDayOfMonth);
$startDayOfWeek = date('w', $firstDayOfMonth); // 0 (Sunday) to 6 (Saturday)

// Get the previous month and year
$prevMonth = $calendarMonth - 1;
$prevYear = $calendarYear;
if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear--;
}
$prevMonthDays = date('t', mktime(0, 0, 0, $prevMonth, 1, $prevYear));
$prevMonthName = date('F', mktime(0, 0, 0, $prevMonth, 1, $prevYear));

// Fetch events from the database
$query = "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as date, time FROM events ORDER BY date ASC";
$result = $conn->query($query);

// Create an associative array to group events by date
$eventsByDate = [];
while ($row = $result->fetch_assoc()) {
    $eventsByDate[$row['date']][] = $row;
}
?>
<?php
include 'db-connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize form data
    $title = trim($_POST['title'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $fb_link = trim($_POST['fb_link'] ?? '');

    // Handle image upload
    $image = null;
    $image_type = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imgTmp = $_FILES['image']['tmp_name'];
        $imgSize = $_FILES['image']['size'];
        $maxSize = 1024 * 1024 * 4; // 4MB limit

        if ($imgSize > $maxSize) {
            exit("<span style='color: red;'>❌ Image size exceeds the maximum limit of 4MB.</span>");
        }

        $imgData = file_get_contents($imgTmp);
        $image = $imgData;
        $image_type = $_FILES['image']['type'];
    }

    // Validate required fields
    $requiredFields = [
        'Title' => $title,
        'Location' => $location,
        'Date' => $date,
        'Time' => $time,
        'Facebook Link' => $fb_link
    ];
    $missing = [];
    foreach ($requiredFields as $label => $value) {
        if (empty($value)) {
            $missing[] = $label;
        }
    }
    if (!empty($missing)) {
        exit("<span style='color: red;'>❌ Please fill in all required fields: " . implode(', ', $missing) . ".</span>");
    }

    // Update the database
    $stmt = $conn->prepare("UPDATE events SET title = ?, location = ?, date = ?, time = ?, fb_link = ?, image = ?, image_type = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sssssssi", $title, $location, $date, $time, $fb_link, $image, $image_type, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            exit("<span style='color: green;'>✅ Event updated successfully!</span>");
        } else {
            $stmt->close();
            $conn->close();
            exit("<span style='color: red;'>❌ Update Error: " . $stmt->error . "</span>");
        }
    } else {
        $conn->close();
        exit("<span style='color: red;'>❌ Prepare Failed: " . $conn->error . "</span>");
    }
}
?>

<div id="content" class="dashboard">

    <style>
        /* Hidden by default */
    </style>
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Calendar Event Manager</h3>
    <div class="main-cont-calendar">
        <div class="upcoming-events">
            <style>
                .previous-month {
                    color: rgb(179, 179, 179);
                }

                .edit-btn {
                    opacity: 0;
                    transition: opacity 0.3s;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                }

                li:hover .edit-btn {
                    opacity: 1;
                }
            </style>
            <h1>May 2025</h1>
            <p class="upcominig-title">Event Calendar</p>
            <ul>
                <?php
                // Print empty days for the first week, filling with previous month's dates
                for ($i = $startDayOfWeek - 1; $i >= 0; $i--) {
                    $prevDay = $prevMonthDays - $i;
                    echo "<li class='previous-month'> $prevMonthName <time datetime='$prevYear-$prevMonth-$prevDay'>$prevDay</time></li>";
                }

                // Print the days of the month
                for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                    $date = sprintf('%04d-%02d-%02d', $calendarYear, $calendarMonth, $day);
                    $events = $eventsByDate[$date] ?? [];
                    $hasEvent = !empty($events);
                    $buttonLabel = $hasEvent ? 'Edit' : 'Add';
                    $eventId = $hasEvent ? $events[0]['id'] : null;

                    $isToday = ($day == $currentDay && $calendarMonth == $currentMonth && $calendarYear == $currentYear);
                    $class = $isToday ? 'class="today"' : '';

                    echo "<li $class style='position: relative;'>";
                    echo "<time>$day</time>";

                    if ($hasEvent) {
                        echo "<div class='event-details'>";
                        foreach ($events as $event) {
                            echo "<p><strong></strong> {$event['title']}</p>";
                            $formattedTime = date('h:i A', strtotime($event['time']));
                            echo "<p><strong></strong> $formattedTime</p>";
                        }
                        echo "</div>";
                        echo "<button class='edit-btn' onclick=\"showPopup('$buttonLabel', '{$event['id']}', '{$event['title']}', '{$event['location']}', '{$event['date']}', '{$event['time']}', '{$event['fb_link']}');\">Edit</button>";
                    } else {
                        echo "<button class='edit-btn' onclick=\"showPopup('$buttonLabel','none')\">Add</button>";
                        echo "</li>";
                    }
                }
                ?>

            </ul>
        </div>
    </div>
    <div id="overlay" onclick="hidePopup()"></div>

    <!-- Popup Box -->
    <div id="popup" class="modal-content">
        <form id="eventForm" enctype="multipart/form-data">
            <div class="form-header">
                <h2 class="form-title">Add/Edit Event</h2>
                <p class="form-subtitle">Fill out the details below</p>
            </div>

            <div class="form-fields">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Event Title" required>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Event Location" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <label for="fb_link">Facebook Link:</label>
                <input type="text" id="fb_link" name="fb_link" placeholder="Facebook Event Link">

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <label for='image-preview'>Image Preview:</label>
                <img id='image-preview' src='' alt='Event Image' style='max-width: 100%; height: auto; margin-top: 10px; display: none;'>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-submit">Save</button>
                <button type="button" class="btn-cancel" onclick="hidePopup()">Cancel</button>
            </div>
        </form>
        <div id="form-response" style="margin-top: 10px;">
            <p></p>
        </div>
    </div>
</div>

<script>
    function showPopup(eventId) {

    }

    function hidePopup() {
        document.getElementById("popup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }



    function createModal() {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) overlay.remove();
        });

        const modal = document.createElement('div');
        modal.className = 'modal-content';

        overlay.appendChild(modal);
        document.body.appendChild(overlay);

        return {
            overlay,
            modal
        };
    }
</script>