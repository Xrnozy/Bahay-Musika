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

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['fbLink'] ?? '');

    if (empty($name) || empty($email)) {
        exit("<span style='color: red; margin-left:20px;'>❌ Name and Email are required.</span>");
    }

    $conn = new mysqli("localhost", "root", "", "my_database");
    if ($conn->connect_error) {
        exit("<span style='color:red;margin-left:20px;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>");
    }

    $check = $conn->prepare("SELECT id FROM members WHERE fb_link = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        exit("<span style='color: orange;margin-left:20px;'>⚠️ User with this email already exists.</span>");
    } else {
        $stmt = $conn->prepare("INSERT INTO members (name, fb_link) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $name, $email);
            if ($stmt->execute()) {
                exit("<span style='color: green;margin-left:20px;'>✅ New user added successfully!</span>");
            } else {
                exit("<span style='color: red;margin-left:20px;'>❌ Insert Error: " . $stmt->error . "</span>");
            }
            $stmt->close();
        } else {
            exit("<span style='color: red;margin-left:20px;'>❌ Prepare Failed: " . $conn->error . "</span>");
        }
    }

    $check->close();
    $conn->close();
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
                                            <input
                                                class="info-input wow fadeInUp name-input"
                                                type="text"
                                                name="name"
                                                placeholder="Last Name"
                                                data-wow-delay="0.2s" />
                                            <input
                                                class="info-input wow fadeInUp name-input"
                                                type="text"
                                                name="fbLink"
                                                placeholder="First Name"
                                                data-wow-delay="0.1s" />

                                            <input
                                                class="info-input wow fadeInUp name-input"
                                                type="text"
                                                name="middleName"
                                                placeholder="Middle Name"
                                                data-wow-delay="0.3s" />
                                            <input
                                                class="info-input wow fadeInUp Ext"
                                                type="text"
                                                name="extName"
                                                placeholder="Ext. Name"
                                                data-wow-delay="0.4s" />
                                        </div>

                                        <input
                                            class="info-input wow fadeInUp"
                                            type="text"
                                            name="profession"
                                            placeholder="Profession"
                                            data-wow-delay="0.5s" />
                                        <label for="dob" class="info-label wow fadeInUp" data-wow-delay="0.6s">Date of Birth</label>
                                        <input
                                            class="info-input wow fadeInUp"
                                            type="date"
                                            name="dob"
                                            placeholder="Date of Birth"
                                            data-wow-delay="0.6s" />
                                        <input
                                            class="info-input wow fadeInUp"
                                            type="tel"
                                            name="phone"
                                            id="phone"
                                            placeholder="Phone Number"
                                            data-wow-delay="0.7s"
                                            oninput="formatPhoneNumber(this)"
                                            pattern="^\+63\d{10}$"
                                            maxlength="13" />
                                        <script></script>

                                        <div class="address">
                                            <input
                                                class="info-input wow fadeInUp"
                                                type="text"
                                                name="street"
                                                id="street"
                                                placeholder="Street Address"
                                                data-wow-delay="0.5s" />

                                            <input
                                                class="info-input wow fadeInUp"
                                                type="text"
                                                name="city"
                                                id="city"
                                                placeholder="City"
                                                data-wow-delay="0.6s" />

                                            <input
                                                class="info-input wow fadeInUp"
                                                type="text"
                                                name="state"
                                                id="state"
                                                placeholder="State/Province"
                                                data-wow-delay="0.7s" />

                                            <input
                                                class="info-input wow fadeInUp"
                                                type="text"
                                                name="zip"
                                                id="zip"
                                                placeholder="Zip Code"
                                                data-wow-delay="0.8s" />

                                            <input
                                                class="info-input wow fadeInUp"
                                                type="text"
                                                name="country"
                                                id="country"
                                                placeholder="Country"
                                                data-wow-delay="0.9s" />
                                        </div>

                                        <div class="form-buttons">
                                            <button class="btn-submit wow fadeInUp" data-wow-delay="0.9s">
                                                Submit
                                            </button>
                                            <button class="btn-cancel wow fadeInUp" data-wow-delay="1.0s">
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
                                                            <input
                                                                @change="updatePreview($refs)"
                                                                x-ref="input"
                                                                type="file"
                                                                accept="image/*,capture=camera"
                                                                name="profileImage"
                                                                id="profileImage"
                                                                class="file-input" />
                                                        </div>

                                                        <div class="filename-display text-sm text-gray-500 mx-2">
                                                            <span x-text="fileName || emptyText"></span>
                                                            <button
                                                                x-show="fileName"
                                                                @click="clearPreview($refs)"
                                                                type="button"
                                                                class="remove-image-btn"
                                                                aria-label="Remove image">
                                                                <svg
                                                                    viewBox="0 0 20 20"
                                                                    fill="currentColor"
                                                                    class="x-circle w-4 h-4"
                                                                    aria-hidden="true"
                                                                    focusable="false">
                                                                    <path
                                                                        fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="image-preview  bg-gray-100">
                                                        <div x-show="!previewPhoto">
                                                            <svg
                                                                class="placeholder-icon h-full w-full text-gray-300"
                                                                fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </div>
                                                        <div
                                                            x-show="previewPhoto"
                                                            class=" overflow-hidden">
                                                            <img
                                                                :src="previewPhoto"
                                                                alt=""
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
                    $conn = new mysqli("localhost", "root", "", "my_database");
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
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="member-details">
                                <h3><?= htmlspecialchars($user['name'] . ', ' . $user['fb_link']) ?></h3>
                                <div class="category-edit-cont">
                                    <h5><?= ucfirst($user['category']) ?></h5>
                                    <h5 class="edit-button" onclick="loadContent('content-manager/update_member.php?id=<?= $user['id'] ?>')">Edit Member Profile</h5>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>
        </div>
    </div>


</div>