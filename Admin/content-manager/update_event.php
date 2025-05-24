<title>Bahay Musika Admin Panel</title>
<link rel="stylesheet" href="content-manager/css/add_member.css">
<link rel="stylesheet" href="css/add_member.css">
<link rel="stylesheet" href="../Admin.css" />
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function imageData(url) {
        const originalUrl = url || '';
        return {
            previewPhoto: originalUrl,
            fileName: null,
            emptyText: originalUrl ? 'No new file chosen' : 'No file chosen',
            updatePreview($refs) {
                var reader,
                    files = $refs.input.files;
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
            }
        };
    }
</script>

<?php
include 'db-connection.php';


$id = $_GET['id'] ?? null;
$event = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
}

if (!$id || !$event) {
    header('Location: events_list.php');
    exit;
}
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
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-ti"></h3>
    <div>

        <div class="main-cont">
            <div class="add-main-cont">
                <form id="userForm">
                    <div class="personal-info-container">
                        <div class="personal-info-header">
                            <h1 class="header-title wow fadeInUp" data-wow-delay="0s">
                                Update Event Information
                            </h1>
                            <p class="header-description wow fadeInUp" data-wow-delay="0.2s">
                                Fill in the details below to update event information.
                            </p>
                            <div class="personal-info-form">
                                <h1 class="form-title wow fadeInUp" data-wow-delay="0s">
                                    Event Information
                                </h1>
                                <div class="form-fields-container">
                                    <div class="form-fields">
                                        <div class="name">
                                            <input class="info-input wow fadeInUp name-input" type="text" name="title"
                                                value="<?= htmlspecialchars($event['title'] ?? '') ?>" placeholder="Event Title" data-wow-delay="0.2s" required />
                                        </div>

                                        <input class="info-input wow fadeInUp" type="text" name="location"
                                            value="<?= htmlspecialchars($event['location'] ?? '') ?>" placeholder="Location" data-wow-delay="0.3s" required />
                                        <label for="date" class="info-label wow fadeInUp" data-wow-delay="0.4s">Date</label>
                                        <input class="info-input wow fadeInUp" type="date" name="date"
                                            value="<?= htmlspecialchars($event['date'] ?? '') ?>" placeholder="Date" data-wow-delay="0.4s" required />
                                        <label for="time" class="info-label wow fadeInUp" data-wow-delay="0.5s">Time</label>
                                        <input class="info-input wow fadeInUp" type="time" name="time"
                                            value="<?= htmlspecialchars($event['time'] ?? '') ?>" placeholder="Time" data-wow-delay="0.5s" required />

                                        <input class="info-input wow fadeInUp" type="text" name="fb_link"
                                            value="<?= htmlspecialchars($event['fb_link'] ?? '') ?>" placeholder="Facebook Event Link" data-wow-delay="0.6s" required />

                                        <div class="form-buttons">
                                            <button class="btn-submit wow fadeInUp" data-wow-delay="0.7s">
                                                Submit
                                            </button>
                                            <button class="btn-cancel wow fadeInUp" data-wow-delay="0.8s" type="button">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>

                                    <div class="profile-image-section layout-input">
                                        <section class="upload-container">
                                            <div class="upload-wrapper">
                                                <div x-data="imageData('data:image/jpeg;base64,<?= base64_encode($event['image'] ?? '') ?>')"
                                                    class="image-upload flex items-center">
                                                    <div class="upload-controls flex items-center">
                                                        <div class="upload-input-wrapper ml-5 rounded-md shadow-sm">
                                                            <input @change="updatePreview($refs)" x-ref="input"
                                                                type="file" accept="image/*,capture=camera"
                                                                name="image" id="image"
                                                                class="file-input" required />
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


                <div id="form-response" style="margin-top: 10px;">
                    <p></p>
                </div>

            </div>


        </div>
    </div>


</div>