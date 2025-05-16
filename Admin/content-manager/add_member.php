<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bahay Musika Admin Panel</title>


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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let valid = true;
            let firstInvalid = null;
            // List of required field names
            const requiredFields = [
                'lastName',
                'firstName',
                'middleName',
                'category',
                'dob',
                'phone',
                'street',
                'city',
                'state',
                'zip',
                'fb_link'
            ];
            requiredFields.forEach(function(field) {
                const input = form.elements[field];
                if (input && !input.value.trim()) {
                    input.classList.add('input-error');
                    if (!firstInvalid) firstInvalid = input;
                    valid = false;
                } else if (input) {
                    input.classList.remove('input-error');
                }
            });
            if (!valid) {
                document.getElementById('form-response').innerHTML = "<span style='color: red; margin-left:20px;'>❌ Please fill in all required fields.</span>";
                if (firstInvalid) firstInvalid.focus();
                return; // Prevent AJAX submit if not valid
            }
            const formData = new FormData(form);
            fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('form-response').innerHTML = data;
                    // Only reset the form if the response indicates success
                    if (data.includes('✅')) {
                        form.reset();
                    }
                });
        });
    });

    /* Add some simple error styling */
    const style = document.createElement('style');
    style.innerHTML = `.input-error { border: 2px solid red !important; }`;
    document.head.appendChild(style);
</script>

<?php
include 'db-connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize form data
    $lastName = trim($_POST['lastName'] ?? '');
    $firstName = trim($_POST['firstName'] ?? '');
    $middleName = trim($_POST['middleName'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $fb_link = trim($_POST['fb_link'] ?? '');

    // Handle profile image upload
    $profile_image = '';
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $imgTmp = $_FILES['profileImage']['tmp_name'];
        $imgName = basename($_FILES['profileImage']['name']);
        $imgPath = '../../App/img/' . $imgName;
        if (move_uploaded_file($imgTmp, $imgPath)) {
            $profile_image = 'App/img/' . $imgName;
        }
    }

<<<<<<< HEAD
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
=======
    $conn = new mysqli("127.0.0.1", "root", "", "my_database", 3307);
    if ($conn->connect_error) {
        exit("<span style='color:red;margin-left:20px;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
    }

    // Check for duplicate fb_link
    $check = $conn->prepare("SELECT id FROM members WHERE fb_link = ?");
    $check->bind_param("s", $fb_link);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        exit("<span style='color: orange;margin-left:20px;'>⚠️ User with this Facebook link already exists.</span>");
    } else {
        $stmt = $conn->prepare("INSERT INTO members (firstName, middleName, lastName, fb_link, category, dob, phone, street, city, state, zip, country, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssssissssss", $firstName, $middleName, $lastName, $fb_link, $category, $dob, $phone, $street, $city, $state, $zip, $country, $profile_image);
            if ($stmt->execute()) {
                $stmt->close();
                $check->close();
                $conn->close();
                exit("<span style='color: green;margin-left:20px;'>✅ New user added successfully!</span>");
            } else {
                $stmt->close();
                $check->close();
                $conn->close();
                exit("<span style='color: red;margin-left:20px;'>❌ Insert Error: " . $stmt->error . "</span>");
            }
        } else {
            $check->close();
            $conn->close();
            exit("<span style='color: red;margin-left:20px;'>❌ Prepare Failed: " . $conn->error . "</span>");
        }
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
                                Add Member
                            </h1>
                            <p class="header-description wow fadeInUp" data-wow-delay="0.2s">
                                Fill in the details below to add a new member.
                            </p>
                            <div class="personal-info-form">
                                <h1 class="form-title wow fadeInUp" data-wow-delay="0s">
                                    Choir Member Personal Information
                                </h1>
                                <div class="form-fields-container">
                                    <div class="form-fields">
                                        <div class="name">
<<<<<<< HEAD
                                            <input class="info-input wow fadeInUp name-input" type="text" name="lastName"
                                                placeholder="Last Name" data-wow-delay="0.2s" required />
                                            <input class="info-input wow fadeInUp name-input" type="text" name="firstName"
                                                placeholder="First Name" data-wow-delay="0.1s" required />
                                            <input class="info-input wow fadeInUp name-input" type="text"
                                                name="middleName" placeholder="Middle Name" data-wow-delay="0.3s" required />
=======
                                            <input class="info-input wow fadeInUp name-input" type="text" name="name"
                                                placeholder="Last Name" data-wow-delay="0.2s" />
                                            <input class="info-input wow fadeInUp name-input" type="text" name="fbLink"
                                                placeholder="First Name" data-wow-delay="0.1s" />

                                            <input class="info-input wow fadeInUp name-input" type="text"
                                                name="middleName" placeholder="Middle Name" data-wow-delay="0.3s" />
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
                                            <input class="info-input wow fadeInUp Ext" type="text" name="extName"
                                                placeholder="Ext. Name" data-wow-delay="0.4s" />
                                        </div>

<<<<<<< HEAD
                                        <input class="info-input wow fadeInUp" type="text" name="category"
                                            placeholder="Category" data-wow-delay="0.5s" required />
=======
                                        <input class="info-input wow fadeInUp" type="text" name="profession"
                                            placeholder="Profession" data-wow-delay="0.5s" />
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
                                        <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Date of
                                            Birth</label>
                                        <input class="info-input wow fadeInUp" type="date" name="dob"
                                            placeholder="Date of Birth" data-wow-delay="0.6s" />
                                        <input class="info-input wow fadeInUp" type="tel" name="phone" id="phone"
                                            placeholder="Phone Number" data-wow-delay="0.7s"
<<<<<<< HEAD
                                            maxlength="11" required />

                                        <div class="address">
                                            <input class="info-input wow fadeInUp" type="text" name="street" id="street"
                                                placeholder="Street Address" data-wow-delay="0.5s" required />

                                            <input class="info-input wow fadeInUp" type="text" name="city" id="city"
                                                placeholder="City" data-wow-delay="0.6s" required />

                                            <input class="info-input wow fadeInUp" type="text" name="state" id="state"
                                                placeholder="State/Province" data-wow-delay="0.7s" required />

                                            <input class="info-input wow fadeInUp" type="text" name="zip" id="zip"
                                                placeholder="Zip Code" data-wow-delay="0.8s" required /> <input class="info-input wow fadeInUp" type="text" name="fb_link"
                                                id="fb_link" placeholder="Facebook Profile Link" data-wow-delay="0.9s" required />
=======
                                            oninput="formatPhoneNumber(this)" pattern="^\+63\d{10}$" maxlength="13" />
                                        <script></script>

                                        <div class="address">
                                            <input class="info-input wow fadeInUp" type="text" name="street" id="street"
                                                placeholder="Street Address" data-wow-delay="0.5s" />

                                            <input class="info-input wow fadeInUp" type="text" name="city" id="city"
                                                placeholder="City" data-wow-delay="0.6s" />

                                            <input class="info-input wow fadeInUp" type="text" name="state" id="state"
                                                placeholder="State/Province" data-wow-delay="0.7s" />

                                            <input class="info-input wow fadeInUp" type="text" name="zip" id="zip"
                                                placeholder="Zip Code" data-wow-delay="0.8s" />

                                            <input class="info-input wow fadeInUp" type="text" name="country"
                                                id="country" placeholder="Country" data-wow-delay="0.9s" />
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
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
                                                <div x-data="imageData()" class="image-upload flex items-center">
                                                    <div class="upload-controls flex items-center">
                                                        <div class="upload-input-wrapper ml-5 rounded-md shadow-sm">
                                                            <input @change="updatePreview($refs)" x-ref="input"
                                                                type="file" accept="image/*,capture=camera"
                                                                name="profileImage" id="profileImage"
<<<<<<< HEAD
                                                                class="file-input" required />
=======
                                                                class="file-input" />
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
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

            <div class="events-list">
                <h2 class="member-title">Members List</h2>

                <div class="list">
                    <?php
<<<<<<< HEAD
                    $result = $conn->query("SELECT * FROM members");
                    while ($user = $result->fetch_assoc()):
                    ?>
                        <div class="member-cont">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile" class="member-img">
                            <?php else: ?>
                                <div class="member-img placeholder">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="member-details">
                                <h3><?= htmlspecialchars($user['name'] . ', ' . $user['fb_link']) ?></h3>
                                <div class="category-edit-cont">
                                    <h5><?= ucfirst($user['category']) ?></h5>
                                    <h5 class="edit-button"
                                        onclick="loadContent('content-manager/update_member.php?id=<?= $user['id'] ?>')">
                                        Edit Member Profile</h5>
                                </div>
=======
                    $conn = new mysqli("127.0.0.1", "root", "", "my_database", 3307);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $result = $conn->query("SELECT * FROM members");
                    while ($user = $result->fetch_assoc()):
                    ?>
                    <div class="member-cont">
                        <?php if (!empty($user['profile_image'])): ?>
                        <img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile" class="member-img">
                        <?php else: ?>
                        <div class="member-img placeholder">
                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <?php endif; ?>

                        <div class="member-details">
                            <h3><?= htmlspecialchars($user['name'] . ', ' . $user['fb_link']) ?></h3>
                            <div class="category-edit-cont">
                                <h5><?= ucfirst($user['category']) ?></h5>
                                <h5 class="edit-button"
                                    onclick="loadContent('content-manager/update_member.php?id=<?= $user['id'] ?>')">
                                    Edit Member Profile</h5>
>>>>>>> 157a0d0e1d4d67b404f471e12cdfd885da14d670
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>

                </div>
            </div>
        </div>
    </div>


</div>