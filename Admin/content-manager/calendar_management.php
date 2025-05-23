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
<div id="content" class="dashboard">

    <style>
        /* Hidden by default */
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
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-content label {
            margin-top: 10px;
            font-weight: bold;
        }

        .modal-content input,
        .modal-content button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal-content button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        .event-details {
            font-size: 14px;
            margin-top: 5px;
            color: #333;
        }

        .event-details p {
            margin: 2px 0;
        }

        .event-details {
            color: white
        }

        /* Popup form styles */
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-title {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .form-subtitle {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #777;
        }

        .form-fields {
            display: flex;
            flex-direction: column;
        }

        .form-fields label {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }

        .form-fields input {
            margin-top: 5px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-fields input::placeholder {
            color: #aaa;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-submit {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-cancel:hover {
            background-color: #c82333;
        }
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
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-submit">Save</button>
                <button type="button" class="btn-cancel" onclick="hidePopup()">Cancel</button>
            </div>
        </form>
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