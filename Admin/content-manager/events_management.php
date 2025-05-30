<!-- Keep this in the main admin.html -->
<link rel="stylesheet" href="css/event_management.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php
include 'db-connection.php';

// Get admin user id from session (assumes session is started and user id is stored as admin_id)
$created_by = $_SESSION['admin_id'] ?? null;
$updated_by = $created_by;

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

    $stmt = $conn->prepare("INSERT INTO events (title, location, date, time, fb_link, image, image_type, created_by, updated_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssssiii", $eventTitle, $eventLocation, $dateOfEvents, $timeOfEvents, $eventsLink, $imageData, $imageType, $created_by, $updated_by);
        if ($stmt->execute()) {
            exit("<span style='color: green;'>✅ Events added successfully!</span>");
        } else {
            exit("<span style='color: red;'>❌ Insert Error: " . $stmt->error . "</span>");
        }
        $stmt->close();
    } else {
        exit("<span style='color: red;'>❌ Prepare Failed: " . $conn->error . "</span>");
    }
}
?>
<script>
    const cache = {}; // Store preloaded pages
    let currentPage = ""; // Start with an empty page so Dashboard loads properly on first click

    function preloadContent(page) {
        fetch(page)
            .then((response) => response.text())
            .then((data) => {
                cache[page] = data; // Store preloaded content
            })
            .catch((error) => console.error("Error preloading content:", error));
    }

    function loadContent(page) {
        if (currentPage === page) {
            console.log(`"${page}" is already loaded, skipping reload.`);
            return; // Prevent reloading the same page
        }

        if (cache[page]) {
            document.getElementById("content").innerHTML = cache[page]; // Load from cache
        } else {
            fetch(page)
                .then((response) => response.text())
                .then((data) => {
                    cache[page] = data; // Store in cache
                    document.getElementById("content").innerHTML = data;
                })
                .catch((error) => console.error("Error loading content:", error));
        }

        currentPage = page;
    }

    // Preload common pages for faster access
    const pages = [
        "content-manager/update_member.php",
    ];

    pages.forEach(preloadContent);
</script>
<div id="content" class="dashboard">

    <link rel="stylesheet" href="../Admin.css" />

    <script>
        function imageData(url) {
            const originalUrl = url || '';
            return {
                previewPhoto: originalUrl,
                fileName: null,
                emptyText: originalUrl ? 'No new file chosen' : 'No file chosen',
                updatePreview($refs) {
                    const reader = new FileReader();
                    const files = $refs.input.files;
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
                }
            };
        }
    </script>

    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Events Manager</h3>

    <div class="main-cont">
        <div class="add-main-cont">
            <form id="userForm" method="POST" enctype="multipart/form-data">
                <div class="personal-info-container">
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

                                    <input class="info-input wow fadeInUp name-input" type="text" name="eventTitle"
                                        placeholder="Events Title" data-wow-delay="0.2s" />

                                    <input class="info-input wow fadeInUp" type="text" name="eventLocation"
                                        placeholder="Events Location" data-wow-delay="0.5s" />
                                    <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Date of the
                                        Events</label>
                                    <input class="info-input wow fadeInUp" type="date" name="dateOfEvents"
                                        placeholder="Date of Events" data-wow-delay="0.6s" />
                                    <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Time of the
                                        Events</label>
                                    <input class="info-input wow fadeInUp" type="time" name="timeOfEvents"
                                        placeholder="Date of Events" data-wow-delay="0.6s" />
                                    <input class="info-input wow fadeInUp" type="tel" name="eventsLink"
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
            <script>
                document.getElementById("userForm").addEventListener("submit", function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);

                    fetch("content-manager/events_management.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            document.querySelector("#form-response p").innerHTML = data;
                            // Clear form on success
                            if (data.includes("✅")) {
                                form.reset();
                                // Reset image preview if using Alpine.js
                                const imageUpload = form.querySelector('[x-data]');
                                if (imageUpload && imageUpload.__x) {
                                    imageUpload.__x.$data.previewPhoto = '';
                                    imageUpload.__x.$data.fileName = null;
                                }
                            }
                        })
                        .catch(error => {
                            document.querySelector("#form-response p").innerHTML = "❌ Something went wrong.";
                        });
                });
            </script>

            <div id="form-response" style="margin-top: 10px;">
                <p></p>
            </div>

        </div>

    </div>

    <div class="events-list">
        <h2 class="member-title">Recent Uploaded Event List</h2>
        <div class="list">
            <?php
            if ($conn->connect_error) {
                echo "<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>";
            } else {
                $result = $conn->query("SELECT id, title, location, date, time, fb_link, image, image_type FROM events ORDER BY id DESC");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imageData = base64_encode($row['image']);
                        $imageType = $row['image_type'];
                        $formattedDate = date('l, d F Y', strtotime($row['date']));
                        $formattedTime = date('h:i A', strtotime($row['time']));
            ?>
                        <div class="news-input">
                            <div class="img-news-cont">
                                <img src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="" class="">
                            </div>

                            <div class="member-details">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <h4><?php echo htmlspecialchars($row['location']); ?></h4>
                                <div class="category-edit-cont">
                                    <h5><?php echo $formattedDate; ?></h5>
                                    <h5><?php echo $formattedTime; ?></h5>
                                </div>
                                <p><a href="<?php echo htmlspecialchars($row['fb_link']); ?>" target="_blank">View on Facebook</a>
                                </p>
                                <h5 class="edit-button" onclick="loadContent('content-manager/update_event.php?id=<?= $row['id'] ?>')">
                                    Edit Event
                                </h5>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<p>No events available.</p>";
                }
            }
            ?>
        </div>
    </div>
</div>
</div>