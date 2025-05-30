<?php
session_start();
require_once 'lib/Db_connection.php';
require_once 'lib/Auth.php';

// Initialize Auth with database connection
$auth = new Auth($conn);

// Check if user is logged in
if (!$auth->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$currentUser = $auth->getCurrentUser();
$userRole = $currentUser['role'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Access - Bahay Musika</title>
    <link rel="stylesheet" href="Admin.css" />
    <script src="../lib/alpinejs.min.js" defer></script>
    <link href="lib/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />

    <style>
        @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
    </style>

    <link rel="stylesheet" href="content-manager/css/event.css" />
    <link rel="stylesheet" href="content-manager/css/update_member.css" />
    <link rel="stylesheet" href="content-manager/css/add_member.css" />
    <link rel="stylesheet" href="content-manager/css/event_management.css" />
    <link rel="stylesheet" href="content-manager/css/dashboard_management.css" />

    <script>
        const cache = {};
        let currentPage = "";

        function preloadContent(page) {
            fetch(page)
                .then((response) => response.text())
                .then((data) => {
                    cache[page] = data;
                })
                .catch((error) => console.error("Error preloading content:", error));
        }

        function loadContent(page) {
            if (currentPage === page) {
                console.log(`"${page}" is already loaded, skipping reload.`);
                return;
            }

            if (cache[page]) {
                document.getElementById("content").innerHTML = cache[page];
            } else {
                fetch(page + "?_=" + new Date().getTime())
                    .then((response) => response.text())
                    .then((data) => {
                        cache[page] = data;
                        document.getElementById("content").innerHTML = data;
                    })
                    .catch((error) => console.error("Error loading content:", error));
            }

            currentPage = page;
        }

        // Preload pages based on user role
        window.onload = function() {
            <?php if ($auth->canManageContent()): ?>
                const contentPages = [
                    "content-manager/dashboard_management.php",
                    "content-manager/news_management.php",
                    "content-manager/events_management.php",
                    "content-manager/calendar_management.php",
                    "content-manager/members_management.php",
                    "content-manager/homepage_management.php",
                    "content-manager/analytics_management.php",
                ];
                contentPages.forEach(preloadContent);
            <?php endif; ?>

            <?php if ($auth->canViewDonations()): ?>
                const socialPages = [
                    "social-manager/dashboard.php",
                    "social-manager/donations_management.php",
                    "social-manager/contacts_management.php",
                ];
                socialPages.forEach(preloadContent);
            <?php endif; ?>

            // Load appropriate dashboard based on role
            <?php if ($userRole === 'content_manager'): ?>
                loadContent('content-manager/dashboard_management.php');
            <?php elseif ($userRole === 'social_manager'): ?>
                loadContent('social-manager/dashboard.php');
            <?php else: ?>
                loadContent('content-manager/dashboard_management.php');
            <?php endif; ?>
        };

        function showPopup(buttonLabel, id, title, location, date, time, fb_link) {
            const popup = document.getElementById("popup");
            const overlay = document.getElementById("overlay");

            if (popup && overlay) {
                popup.style.display = "block";
                overlay.style.display = "block";
                if (buttonLabel === "Add") {
                    const titleField = document.getElementById("title");
                    const locationField = document.getElementById("location");
                    const dateField = document.getElementById("date");
                    const timeField = document.getElementById("time");
                    const fbLinkField = document.getElementById("fb_link");

                    if (titleField) titleField.value = "";
                    if (locationField) locationField.value = "";
                    if (dateField) dateField.value = "";
                    if (timeField) timeField.value = "";
                    if (fbLinkField) fbLinkField.value = "";
                }
                if (id != null && title != null && location != null && date != null && time != null && fb_link != null) {
                    const titleField = document.getElementById("title");
                    const locationField = document.getElementById("location");
                    const dateField = document.getElementById("date");
                    const timeField = document.getElementById("time");
                    const fbLinkField = document.getElementById("fb_link");
                    if (titleField) titleField.value = title;
                    if (locationField) locationField.value = location;
                    if (dateField) dateField.value = date;
                    if (timeField) timeField.value = time;
                    if (fbLinkField) fbLinkField.value = fb_link;
                }
            }
        }

        function hidePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function imageData(url) {
            const originalUrl = url || "";
            return {
                previewPhoto: originalUrl,
                fileName: null,
                emptyText: originalUrl ? "No new file chosen" : "No file chosen",
                updatePreview($refs) {
                    var reader, files = $refs.input.files;
                    reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewPhoto = e.target.result;
                        this.fileName = files[0].name;
                    };
                    reader.readAsDataURL(files[0]);
                },
                clearPreview($refs) {
                    $refs.input.value = null;
                    this.previewPhoto = originalUrl;
                    this.fileName = false;
                },
            };
        }

        function submitForm(formId) {
            var form = document.getElementById(formId);
            var formData = new FormData(form);

            fetch("content-manager/homepage_management.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.text())
                .then((data) => {
                    document.getElementById("content").innerHTML = data;
                })
                .catch((error) => console.error("Error submitting form:", error));
        }
    </script>
</head>

<body>
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <script src="lib/wow/wow.min.js"></script>

    <div class="navParent">
        <nav>
            <div class="company-name">Bahay Musika Admin</div>
            <div class="profile-cont">
                <div class="admin-profile-cont">
                    <div class="admin-title"><?php echo htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']); ?></div>
                    <div class="admin-status"><?php echo ucfirst(str_replace('_', ' ', $userRole)); ?></div>
                </div>
            </div>

            <div class="accordion accordion-flush" id="adminAccordion">
                <!-- Dashboard -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-dashboard">
                        <button class="accordion-button collapsed no-arrow" type="button" onclick="<?php echo $userRole === 'social_manager' ? "loadContent('social-manager/dashboard.php')" : "loadContent('content-manager/dashboard_management.php')"; ?>">
                            Dashboard
                        </button>
                    </h2>
                </div>

                <?php if ($auth->canManageContent()): ?>
                    <!-- News Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-news">
                            <button class="accordion-button collapsed no-arrow" type="button" data-bs-toggle="collapse" data-bs-target="#newsOptions" aria-expanded="false" aria-controls="newsOptions">
                                News Management
                            </button>
                        </h2>
                        <div id="newsOptions" class="accordion-collapse collapse" aria-labelledby="heading-news" data-bs-parent="#adminAccordion">
                            <div class="accordion-body">
                                <button class="btn btn-link" type="button" onclick="loadContent('content-manager/news_management.php')">
                                    Add News
                                </button>
                                <button class="btn btn-link" type="button" onclick="loadContent('content-manager/edit_news.php')">
                                    Edit News
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Events Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-events">
                            <button class="accordion-button collapsed no-arrow" type="button" data-bs-toggle="collapse" data-bs-target="#eventsOptions" aria-expanded="false" aria-controls="eventsOptions">
                                Events Management
                            </button>
                        </h2>
                        <div id="eventsOptions" class="accordion-collapse collapse" aria-labelledby="heading-events" data-bs-parent="#adminAccordion">
                            <div class="accordion-body">
                                <button class="btn btn-link" type="button" onclick="loadContent('content-manager/events_management.php')">
                                    Add Event
                                </button>
                                <button class="btn btn-link" type="button" onclick="loadContent('content-manager/update_event.php')">
                                    Edit Event
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Events -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-calendar">
                            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('content-manager/calendar_management.php')">
                                Edit Calendar Events
                            </button>
                        </h2>
                    </div>

                    <!-- Members Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-members">
                            <button class="accordion-button collapsed no-arrow" type="button" data-bs-toggle="collapse" data-bs-target="#membersOptions" aria-expanded="false" aria-controls="membersOptions">
                                Members Management
                            </button>
                        </h2>
                        <div id="membersOptions" class="accordion-collapse collapse" aria-labelledby="heading-members" data-bs-parent="#adminAccordion">
                            <div class="accordion-body">
                                <button class="btn btn-link" type="button" onclick="loadContent('content-manager/add_member.php')">
                                    Add Member
                                </button>
                                <button class="btn btn-link" type="button" onclick="loadContent('content-manager/update_member.php')">
                                    Edit Member
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Homepage Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-homepage">
                            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('content-manager/homepage_management.php')">
                                Homepage Management
                            </button>
                        </h2>
                    </div>

                    <!-- Generate Report -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-report">
                            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('content-manager/generate.php')">
                                Generate Report
                            </button>
                        </h2>
                    </div>
                <?php endif; ?>

                <?php if ($auth->canViewDonations()): ?>
                    <!-- Donations Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-donations">
                            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('social-manager/donations_management.php')">
                                Donations Management
                            </button>
                        </h2>
                    </div>

                    <!-- Contacts Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-contacts">
                            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('social-manager/contacts_management.php')">
                                Contacts Management
                            </button>
                        </h2>
                    </div>

                    <!-- Comments Management -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-comments">
                            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('social-manager/comments_management.php')">
                                Comments Management
                            </button>
                        </h2>
                    </div>
                <?php endif; ?>

                <!-- Logout -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-logout">
                        <button class="accordion-button collapsed no-arrow" type="button" onclick="window.location.href='login.php?logout=1'">
                            Logout
                        </button>
                    </h2>
                </div>
            </div>
        </nav>
    </div>

    <div class="dashboard-parent">
        <div id="content" class="dashboard">
            <div class="intro-cont">
                <h1 class="intro">Welcome to Admin Panel</h1>
                <p style="color: white; margin-top: 20px;">Loading dashboard...</p>
            </div>
        </div>
    </div>

    <script src="../lib/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>