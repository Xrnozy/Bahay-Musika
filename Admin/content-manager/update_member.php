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
$user = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

if (!$id || !$user) {
    header('Location: members_management.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize form data
    $lastName = trim($_POST['lastName'] ?? '');
    $firstName = trim($_POST['firstName'] ?? '');
    $middleName = trim($_POST['middleName'] ?? '');
    $extName = trim($_POST['extName'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $fb_link = trim($_POST['fb_link'] ?? '');

    // Handle profile image upload
    $profile_image = null;
    $profile_image_type = null;
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $imgTmp = $_FILES['profileImage']['tmp_name'];
        $imgSize = $_FILES['profileImage']['size'];
        $maxSize = 1024 * 1024 * 4; // 4MB limit

        if ($imgSize > $maxSize) {
            exit("<span style='color: red; margin-left:20px;'>❌ Image size exceeds the maximum limit of 4MB.</span>");
        }

        $imgData = file_get_contents($imgTmp); // Read the file content as binary data
        $profile_image = $imgData;
        $profile_image_type = $_FILES['profileImage']['type']; // Store the MIME type of the image
    }

    // Validate all required fields
    $requiredFields = [
        'First Name' => $firstName,
        'Last Name' => $lastName,
        'Middle Name' => $middleName,
        'Category' => $category,
        'Date of Birth' => $dob,
        'Phone' => $phone,
        'Street' => $street,
        'City' => $city,
        'State' => $state,
        'Zip' => $zip,
        'Facebook Link' => $fb_link
    ];
    $missing = [];
    foreach ($requiredFields as $label => $value) {
        if (empty($value)) {
            $missing[] = $label;
        }
    }
    if (!empty($missing)) {
        exit("<span style='color: red; margin-left:20px;'>❌ Please fill in all required fields: " . implode(', ', $missing) . ".</span>");
    }

    // Check for duplicate fb_link
    $check = $conn->prepare("SELECT id FROM members WHERE fb_link = ?");
    $check->bind_param("s", $fb_link);
    $check->execute();
    $check->store_result();

    // Update the database query to update the table instead of inserting a new record
    $stmt = $conn->prepare("UPDATE members SET firstName = ?, middleName = ?, lastName = ?, extName = ?,fb_link = ?, category = ?, dob = ?, phone = ?, street = ?, city = ?, state = ?, zip = ?, profile_image = ?, profile_image_type = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sssssssissssssi", $firstName, $middleName, $lastName, $extName, $fb_link, $category, $dob, $phone, $street, $city, $state, $zip, $profile_image, $profile_image_type, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $check->close();
            $conn->close();
            exit("<span style='color: green;margin-left:20px;'>✅ User updated successfully!</span>");
        } else {
            $stmt->close();
            $check->close();
            $conn->close();
            exit("<span style='color: red;margin-left:20px;'>❌ Update Error: " . $stmt->error . "</span>");
        }
    } else {
        $check->close();
        $conn->close();
        exit("<span style='color: red;margin-left:20px;'>❌ Prepare Failed: " . $conn->error . "</span>");
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
                <form id="userForm" onsubmit="return handleSubmit(event)">
                    <div class="personal-info-container">
                        <div class="personal-info-header">
                            <h1 class="header-title wow fadeInUp" data-wow-delay="0s">
                                Update Members Information
                            </h1>
                            <p class="header-description wow fadeInUp" data-wow-delay="0.2s">
                                Fill in the details below to update member information.
                            </p>
                            <div class="personal-info-form">
                                <h1 class="form-title wow fadeInUp" data-wow-delay="0s">
                                    Choir Member Personal Information
                                </h1>
                                <div class="form-fields-container">
                                    <div class="form-fields">
                                        <div class="name">
                                            <input class="info-input wow fadeInUp name-input" type="text" name="lastName"
                                                value="<?= htmlspecialchars($user['lastName'] ?? '') ?>" placeholder="Last Name" data-wow-delay="0.2s" required />
                                            <input class="info-input wow fadeInUp name-input" type="text" name="firstName"
                                                value="<?= htmlspecialchars($user['firstName'] ?? '') ?>" placeholder="First Name" data-wow-delay="0.1s" required />
                                            <input class="info-input wow fadeInUp name-input" type="text" name="middleName"
                                                value="<?= htmlspecialchars($user['middleName'] ?? '') ?>" placeholder="Middle Name" data-wow-delay="0.3s" required />
                                            <input class="info-input wow fadeInUp Ext" type="text" name="extName"
                                                value="<?= htmlspecialchars($user['extName'] ?? '') ?>" placeholder="Ext. Name" data-wow-delay="0.4s" />
                                        </div>

                                        <input class="info-input wow fadeInUp" type="text" name="category"
                                            value="<?= htmlspecialchars($user['category'] ?? '') ?>" placeholder="Category" data-wow-delay="0.5s" required />
                                        <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Date of
                                            Birth</label>
                                        <input class="info-input wow fadeInUp" type="date" name="dob"
                                            value="<?= htmlspecialchars($user['dob'] ?? '') ?>" placeholder="Date of Birth" data-wow-delay="0.6s" />
                                        <input class="info-input wow fadeInUp" type="tel" name="phone"
                                            value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Phone Number" data-wow-delay="0.7s"
                                            maxlength="11" required />

                                        <div class="address">
                                            <input class="info-input wow fadeInUp" type="text" name="street"
                                                value="<?= htmlspecialchars($user['street'] ?? '') ?>" placeholder="Street Address" data-wow-delay="0.5s" required />

                                            <input class="info-input wow fadeInUp" type="text" name="city"
                                                value="<?= htmlspecialchars($user['city'] ?? '') ?>" placeholder="City" data-wow-delay="0.6s" required />

                                            <input class="info-input wow fadeInUp" type="text" name="state"
                                                value="<?= htmlspecialchars($user['state'] ?? '') ?>" placeholder="State/Province" data-wow-delay="0.7s" required />

                                            <input class="info-input wow fadeInUp" type="text" name="zip"
                                                value="<?= htmlspecialchars($user['zip'] ?? '') ?>" placeholder="Zip Code" data-wow-delay="0.8s" required />
                                            <input class="info-input wow fadeInUp" type="text" name="fb_link"
                                                value="<?= htmlspecialchars($user['fb_link'] ?? '') ?>" placeholder="Facebook Profile Link" data-wow-delay="0.9s" required />
                                        </div>

                                        <div class="form-buttons">
                                            <button class="btn-submit wow fadeInUp" data-wow-delay="0.9s">
                                                Submit
                                            </button>
                                            <button class="btn-cancel wow fadeInUp" data-wow-delay="1.0s" type="button">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>

                                    <div class="profile-image-section layout-input">
                                        <section class="upload-container">
                                            <div class="upload-wrapper">
                                                <div x-data="imageData('data:image/jpeg;base64,<?= base64_encode($user['profile_image'] ?? '') ?>')"
                                                    class="image-upload flex items-center">
                                                    <div class="upload-controls flex items-center">
                                                        <div class="upload-input-wrapper ml-5 rounded-md shadow-sm">
                                                            <input @change="updatePreview($refs)" x-ref="input"
                                                                type="file" accept="image/*,capture=camera"
                                                                name="profileImage" id="profileImage"
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

<!-- Custom Popup -->
<div id="confirmPopup" class="popup-overlay">
    <div class="popup-content">
        <h3>Confirm Update</h3>
        <p>Are you sure you want to update this member's information?</p>
        <div class="popup-buttons">
            <button onclick="confirmUpdate()" class="confirm-btn">Yes, Update</button>
            <button onclick="closePopup()" class="cancel-btn">Cancel</button>
        </div>
    </div>
</div>

<style>
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 90%;
        text-align: center;
    }

    .popup-content h3 {
        margin-top: 0;
        color: #333;
    }

    .popup-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .confirm-btn,
    .cancel-btn {
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .confirm-btn {
        background-color: #4CAF50;
        color: white;
    }

    .confirm-btn:hover {
        background-color: #45a049;
    }

    .cancel-btn {
        background-color: #f44336;
        color: white;
    }

    .cancel-btn:hover {
        background-color: #da190b;
    }
</style>