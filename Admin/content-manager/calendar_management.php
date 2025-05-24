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

// Count the number of events for each date
$eventCountByDate = [];
foreach ($eventsByDate as $date => $events) {
    $eventCountByDate[$date] = count($events);
}
?>
<?php
include 'db-connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventTitle = trim($_POST['eventTitle'] ?? '');
    $eventLocation = trim($_POST['eventLocation'] ?? '');
    $dateOfEvents = trim($_POST['dateOfEvents'] ?? '');
    $timeOfEvents = trim($_POST['timeOfEvents'] ?? '');
    $eventsLink = trim($_POST['eventsLink'] ?? '');
    $profileImage = $_FILES['profileImage'] ?? null;

    if (empty($eventTitle) || empty($eventLocation) || empty($dateOfEvents) || empty($timeOfEvents) || empty($eventsLink) || !$profileImage) {
        exit("<span style='color: red;'>❌ All fields, including the image, are required.</span>");
    }

    $imageData = file_get_contents($profileImage['tmp_name']);
    $imageType = $profileImage['type'];


    if ($conn->connect_error) {
        exit("<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
    }

    $stmt = $conn->prepare("INSERT INTO events (title, location, date, time, fb_link, image, image_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssssss", $eventTitle, $eventLocation, $dateOfEvents, $timeOfEvents, $eventsLink, $imageData, $imageType);
        if ($stmt->execute()) {
            // Close the statement before exiting
            $stmt->close();
            exit("<span style='color: green;'>✅ Events added successfully!</span>");
        } else {
            exit("<span style='color: red;'>❌ Insert Error: " . $stmt->error . "</span>");
        }
    } else {
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

                .done {
                    background-color: rgb(16, 194, 0);
                    color: white;
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

                    // Update the logic for highlighting the current day
                    $isToday = ($day == $currentDay && $calendarMonth == date('n') && $calendarYear == date('Y'));
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
                        $eventCount = count($events);
                        if ($event['date'] < date('Y-m-d')) {
                            echo "<button class='edit-btn done' onclick=\"showPopup('$eventCount','$buttonLabel', '{$event['id']}', '{$event['title']}', '{$event['location']}', '{$event['date']}', '{$event['time']}', '{$event['fb_link']}');\">Done</button>";
                        } else {
                            echo "<button class='edit-btn' onclick=\"showPopup('$eventCount','$buttonLabel', '{$event['id']}', '{$event['title']}', '{$event['location']}', '{$event['date']}', '{$event['time']}', '{$event['fb_link']}');\">Edit</button>";
                        }
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
        <form id="userForm" method="POST" enctype="multipart/form-data">
            <div class="personal-info-cont">
                <link rel="stylesheet" href="../personalInfo.css" />
                <div class="personal-info-form">
                    <div class="form-header">

                        <div class="title">
                            <h1 class="form-title wow fadeInUp" data-wow-delay="0s">
                                Events Announcement Form
                            </h1>
                            <p class="form-subtitle">Please fill out the form below</p>
                        </div>

                        <div class="form-fields-container">
                            <div class="form-fields">

                                <input class="info-input wow fadeInUp name-input" id="title" type="text" name="eventTitle"
                                    placeholder="Events Title" data-wow-delay="0.2s" />

                                <input class="info-input wow fadeInUp" type="text" id="location" name="eventLocation"
                                    placeholder="Events Location" data-wow-delay="0.5s" />
                                <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Date of the
                                    Events</label>
                                <input class="info-input wow fadeInUp" type="date" id="date" name="dateOfEvents"
                                    placeholder="Date of Events" data-wow-delay="0.6s" />
                                <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Time of the
                                    Events</label>
                                <input class="info-input wow fadeInUp" type="time" id="time" name="timeOfEvents"
                                    placeholder="Date of Events" data-wow-delay="0.6s" />
                                <input class="info-input wow fadeInUp" type="tel" id="fb_link" name="eventsLink"
                                    placeholder="Facebook Events Link" data-wow-delay="0.7s" />
                                <script></script>

                                <div class="form-buttons">
                                    <button class="btn-submit btn-news wow fadeInUp" data-wow-delay="0.9s">
                                        Submit
                                    </button>
                                    <button class="btn-cancel btn-news wow fadeInUp" data-wow-delay="1.0s">
                                        Cancel
                                    </button>
                                </div>
                            </div>

                            <div class="profile-image-section layout-input">
                                <section class="upload-container">
                                    <div class="upload-wrapper">
                                        <div x-data="imageData()" class="image-upload flex items-center">
                                            <div class="upload-controls flex items-center">
                                                <div class="upload-input-wrapper ml-5 rounded-md shadow-sm">
                                                    <input @change="updatePreview($refs)" x-ref="input" type="file"
                                                        accept="image/*,capture=camera" name="profileImage"
                                                        id="profileImage" class="file-input" />
                                                </div>

                                                <div class="filename-display text-sm text-gray-500 mx-2">
                                                    <span x-text="fileName || emptyText"></span>
                                                    <button x-show="fileName" @click="clearPreview($refs)"
                                                        type="button" class="remove-image-btn"
                                                        aria-label="Remove image">
                                                        <svg viewBox="0 0 20 20" fill="currentColor"
                                                            class="x-circle w-4 h-4" aria-hidden="true"
                                                            focusable="false">
                                                            <path fill-rule="evenodd"
                                                                <<<<<<< HEAD
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293-1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"=======d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z">>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="image-preview  bg-gray-100">
                                                <div x-show="!previewPhoto">
                                                    <svg class="placeholder-icon h-full w-full text-gray-300"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <div x-show="previewPhoto" class=" overflow-hidden">
                                                    <img :src="previewPhoto" alt=""
                                                        class="preview-image object-cover" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

        </form>
        <div id="form-response" style="margin-top: 10px;">
            <p></p>
        </div>
        <style>

        </style>
        <div id="event_list-calendar">
            <h2 class="event-title">Events List</h2>
            <div class="list">
                <?php
                $selectedDate = $_GET['selected_date'] ?? null;
                if ($selectedDate) {
                    $result = $conn->query("SELECT * FROM events WHERE date = '$selectedDate'");
                } else {
                    $result = $conn->query("SELECT * FROM events");
                }
                if ($result->num_rows > 0):
                    while ($event = $result->fetch_assoc()): ?>
                        <div class="event-cont">
                            <?php if (!empty($event['image'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($event['image']) ?>" alt="Event" class="event-img">
                            <?php else: ?>
                                <div class="event-img placeholder">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="event-details-child">
                                <h3 class="event-details-child"><?= htmlspecialchars($event['title']) ?></h3>
                                <h5 class="event-details-child"><?= htmlspecialchars($event['date']) ?></h5>
                            </div>
                            <h5 class="edit-button" onclick="loadContent('content-manager/update_event.php?id=<?= $event['id'] ?>')">Edit Event Details</h5>

                        </div>
                <?php endwhile;
                endif; ?>
            </div>
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

<style>
    #popup {
        display: none;
        position: fixed;
        height: auto;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: white;
        border: 2px solid #333;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        width:
            60vw;
        border-radius: 8px;
    }
</style>
<style>
    .events-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        height: 100%;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-left: 0px;
    }

    .event-cont {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .event-cont:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .event-img {
        width: 60px;
        height: 60px;
        border-radius: 10%;
        object-fit: cover;
        border: 2px solid #ddd;
        margin-right: 0px;
    }

    .event-details {
        flex: 1;
    }

    .event-details h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .category-edit-cont {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
    }

    .category-edit-cont h5 {
        margin: 0;
        font-size: 14px;
        color: #666;
    }

    .edit-button {
        cursor: pointer;
        color: #007bff;
        text-decoration: underline;
        font-size: 14px;
        color: white;
    }

    .edit-button:hover {
        color: #0056b3;
    }

    .event-details-child {
        color: #333333
    }
</style>