<?php
include 'db-connection.php';

// Initialize counts
$newsCount = 0;
$eventsCount = 0;
$membersCount = 0;

// Fetch counts with checks
$newsResult = $conn->query("SELECT COUNT(*) as count FROM news");
if ($newsResult) {
    $newsCount = $newsResult->fetch_assoc()['count'];
}

$eventsResult = $conn->query("SELECT COUNT(*) as count FROM events");
if ($eventsResult) {
    $eventsCount = $eventsResult->fetch_assoc()['count'];
}

$membersResult = $conn->query("SELECT COUNT(*) as count FROM members");
if ($membersResult) {
    $membersCount = $membersResult->fetch_assoc()['count'];
}

// Fetch latest news and events
$latestNews = $conn->query("SELECT title, created_at FROM news ORDER BY created_at DESC LIMIT 5");
$latestEvents = $conn->query("SELECT title, created_at FROM events ORDER BY created_at DESC LIMIT 5");

// Fetch members list BEFORE closing the connection
$membersList = [];
$membersResult = $conn->query("SELECT * FROM members");
if ($membersResult) {
    while ($user = $membersResult->fetch_assoc()) {
        $membersList[] = $user;
    }
}

$conn->close();
?>


<link rel="stylesheet" href="../Admin.css">
<link rel="stylesheet" href="css/dashboard_management.css">
<link rel="stylesheet" href="content-manager/css/dashboard_management.css">
<div id="content" class="dashboard">


    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Dashboard</h3>
    <div class="main-container">
        <div class="first-container">
            <div class="top-container">
                <div class="news-article">
                    <h3>Total News Articles</h3>
                    <h1 class="total-news"><?php echo $newsCount; ?></h1>
                    <div class="total-recent">
                        <h5>Recent update/upload:</h5>
                        <h5 class="recent-news">None</h5>
                    </div>
                    <div class="text-button">
                        <h5 class="text-button-news" onclick="loadContent('content-manager/news_management.php')">View
                            all news</h5>
                    </div>
                </div>
                <div class="total-events">
                    <div class="total-event-cont">
                        <h3>Total Events</h3>
                        <h1 class="total-event"><?php echo $eventsCount; ?></h1>
                        <div class="total-event-recent">
                            <h5 class="recent-event">None</h5>
                            <h5>more recent uploaded news</h5>
                        </div>
                        <div class="text-button">
                            <h5 class="text-button-events"
                                onclick="loadContent('content-manager/events_management.php')">View all events</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-container">
                <div class="latest-upload">
                    <h2>Latest Event and News</h2>
                    <div class="latest-upload-cont">
                        <h3>Latest News</h3>
                        <ul>
                            <?php while ($news = $latestNews->fetch_assoc()): ?>
                                <li><?php echo $news['title'] . " (" . $news['created_at'] . ")"; ?></li>
                            <?php endwhile; ?>
                        </ul>
                        <h3>Latest Events</h3>
                        <ul>
                            <?php while ($event = $latestEvents->fetch_assoc()): ?>
                                <li><?php echo $event['title'] . " (" . $event['created_at'] . ")"; ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="second-container">
            <div class="top-container">
                <div class="choir-count-cont">
                    <div class="latest-members">
                        <h3>Total Members</h3>
                        <h1 class="total-members"> <?php echo $membersCount; ?></h1>
                        <div class="total-recent">
                            <h5 class="recent-member">None</h5>
                            <h5>more recent uploaded news</h5>
                        </div>
                    </div>
                    <div class="text-button">
                        <h5 class="text-button-members" onclick="loadContent('content-manager/add_member.php')">Update
                            Members</h5>
                    </div>
                </div>
            </div>
            <div class="bottom-container">
                <div class="members-list">
                    <h2 class="member-title">Members List</h2>

                    <div class="list">
                        <?php foreach ($membersList as $user):
                            $imageData = base64_encode($user['profile_image']);
                            $imageType = $user['profile_image_type'];
                        ?>

                            <div class="member-cont">
                                <?php if (!empty($user['profile_image'])): ?>

                                    <img src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="Profile" class="member-img">
                                <?php else: ?>
                                    <div class="member-img placeholder">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>

                                <div class="member-details">
                                    <h3><?= htmlspecialchars($user['firstName'] . ', ' . $user['lastName']) ?></h3>
                                    <div class="category-edit-cont">
                                        <h5><?= ucfirst($user['category']) ?></h5>
                                        <h5 class="edit-button"
                                            onclick="loadContent('content-manager/update_member.php?id=<?= $user['id'] ?>')">
                                            Edit Member Profile</h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const newsCount = <?php echo json_encode($newsCount); ?>;
        const eventsCount = <?php echo json_encode($eventsCount); ?>;
        const membersCount = <?php echo json_encode($membersCount); ?>;

        console.log({
            newsCount,
            eventsCount,
            membersCount
        });

        // Wait until the whole page is loaded before updating
        window.addEventListener("DOMContentLoaded", () => {
            document.querySelector('.total-news').textContent = newsCount;
            document.querySelector('.total-event').textContent = eventsCount;
            document.querySelector('.total-members').textContent = membersCount;
        });
    </script>

</div>