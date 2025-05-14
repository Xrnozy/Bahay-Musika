<!-- Keep this in the main admin.html -->
<link rel="stylesheet" href="css/event_management.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newsTitle = trim($_POST['newsTitle'] ?? '');
    $newsLocation = trim($_POST['newsLocation'] ?? '');
    $dateOfNews = trim($_POST['dateOfNews'] ?? '');
    $timeOfNews = trim($_POST['timeOfNews'] ?? '');
    $newsLink = trim($_POST['NewsLink'] ?? '');
    $profileImage = $_FILES['profileImage'] ?? null;

    if (empty($newsTitle) || empty($newsLocation) || empty($dateOfNews) || empty($timeOfNews) || empty($newsLink) || !$profileImage) {
        exit("<span style='color: red;'>❌ All fields, including the image, are required.</span>");
    }

    $imageData = file_get_contents($profileImage['tmp_name']);
    $imageType = $profileImage['type'];

    $conn = new mysqli("127.0.0.1", "root", "", "my_database",3307);
    if ($conn->connect_error) {
        exit("<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
    }

    $stmt = $conn->prepare("INSERT INTO news (title, location, date, time, fb_link, image, image_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssssss", $newsTitle, $newsLocation, $dateOfNews, $timeOfNews, $newsLink, $imageData, $imageType);
        if ($stmt->execute()) {
            exit("<span style='color: green;'>✅ News added successfully!</span>");
        } else {
            exit("<span style='color: red;'>❌ Insert Error: " . $stmt->error . "</span>");
        }
        $stmt->close();
    } else {
        exit("<span style='color: red;'>❌ Prepare Failed: " . $conn->error . "</span>");
    }

    $conn->close();
}
?>

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
    <h3 class="dashboard-title">New Manager</h3>

    <div class="main-cont">
        <div class="add-main-cont">
            <form id="userForm" enctype="multipart/form-data">
                <div class="personal-info-container">
                    <link rel="stylesheet" href="../personalInfo.css" />
                    <div class="personal-info-form">
                        <div class="form-header">

                            <div class="title">
                                <h1 class="form-title wow fadeInUp" data-wow-delay="0s">
                                    News Announcement Form
                                </h1>
                                <p class="form-subtitle">Please fill out the form below</p>
                            </div>

                            <div class="form-fields-container">
                                <div class="form-fields">

                                    <input class="info-input wow fadeInUp name-input" type="text" name="newsTitle"
                                        placeholder="News Title" data-wow-delay="0.2s" />

                                    <input class="info-input wow fadeInUp" type="text" name="newsLocation"
                                        placeholder="News Location" data-wow-delay="0.5s" />
                                    <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Date of the
                                        News</label>
                                    <input class="info-input wow fadeInUp" type="date" name="dateOfNews"
                                        placeholder="Date of News" data-wow-delay="0.6s" />
                                    <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Time of the
                                        News</label>
                                    <input class="info-input wow fadeInUp" type="time" name="timeOfNews"
                                        placeholder="Date of News" data-wow-delay="0.6s" />
                                    <input class="info-input wow fadeInUp" type="tel" name="NewsLink"
                                        placeholder="Facebook News Link" data-wow-delay="0.7s" />
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
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
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
            document.getElementById("user-form").addEventListener("submit", function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                fetch("process.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.querySelector("#for-response p").innerHTML = data;
                    })
                    .catch(error => {
                        document.querySelector("#for-response p").innerHTML = "❌ Something went wrong.";
                    });
            });
            </script>

            <div id="form-response" style="margin-top: 10px;">
                <p></p>
            </div>

        </div>

    </div>

    <div class="events-list">
        <h2 class="member-title">Recent Uploaded News List</h2>
        <div class="list">
            <?php
            $conn = new mysqli("127.0.0.1", "root", "", "my_database", 3307);
            if ($conn->connect_error) {
                echo "<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>";
            } else {
                $result = $conn->query("SELECT title, location, date, time, fb_link, image, image_type FROM news ORDER BY id DESC");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imageData = base64_encode($row['image']);
                        $imageType = $row['image_type'];
            ?>
            <div class="news-input">
                <div class="img-news-cont">
                    <img src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="" class="">
                </div>

                <div class="member-details">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <h4><?php echo htmlspecialchars($row['location']); ?></h4>
                    <div class="category-edit-cont">
                        <h5><?php echo htmlspecialchars($row['date']); ?></h5>
                        <h5><?php echo htmlspecialchars($row['time']); ?></h5>
                    </div>
                    <p><a href="<?php echo htmlspecialchars($row['fb_link']); ?>" target="_blank">View on Facebook</a>
                    </p>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo "<p>No news available.</p>";
                }
                $conn->close();
            }
            ?>
        </div>
    </div>
</div>