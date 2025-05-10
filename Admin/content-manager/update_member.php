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
$conn = new mysqli("localhost", "root", "", "my_database");
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

$user = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "<p style='color:red;'>Invalid member ID.</p>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<p style='color:red;'>Member not found.</p>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = trim($_POST['name'] ?? '');
    $fb_link = trim($_POST['fb_link'] ?? '');
    $category = trim($_POST['category'] ?? '');

    if (!$id || !$name) {
        echo "<p style='color:red;'>ID and name are required.</p>";
        exit;
    }

    $profileImagePath = '';
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = basename($_FILES['profileImage']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid("img_") . "." . $fileExtension;
            $uploadPath = "../uploads/" . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $profileImagePath = $uploadPath;
            } else {
                echo "<p style='color:red;'>Error uploading image.</p>";
                exit;
            }
        } else {
            echo "<p style='color:red;'>Invalid image type.</p>";
            exit;
        }
    }


    // Prevent further HTML rendering if updated via AJAX
}
?>

<div id="content" class="dashboard">
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Update Choir Member Profile</h3>

    <div class="main-cont">
        <form id="editMemberForm">
            <div class="personal-info-container">
                <link rel="stylesheet" href="../personalInfo.css" />
                <div class="personal-info-form">
                    <h1 class="form-title">Personal Information</h1>
                    <div class="form-fields-container">
                        <div class="form-fields">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                            <input class="info-input" type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Name" />
                            <input class="info-input" type="text" name="fb_link" value="<?= htmlspecialchars($user['fb_link']) ?>" placeholder="Facebook Link" />
                            <input class="info-input" type="text" name="category" value="<?= htmlspecialchars($user['category']) ?>" placeholder="Category" />
                            <div class="form-buttons">
                                <button type="submit" class="btn-submit">Save Changes</button>
                                <button type="reset" class="btn-cancel">Cancel</button>
                            </div>
                        </div>

                        <div class="profile-image-section layout-input">
                            <section class="upload-container">
                                <div class="upload-wrapper">
                                    <div x-data="imageData('<?= htmlspecialchars($user['profile_image'] ?? '') ?>')" class="image-upload flex items-center">
                                        <div class="upload-controls flex items-center">
                                            <div class="upload-input-wrapper ml-5 rounded-md shadow-sm">
                                                <input @change="updatePreview($refs)" x-ref="input" type="file" accept="image/*,capture=camera" name="profileImage" id="profileImage" class="file-input" />
                                            </div>
                                            <div class="filename-display text-sm text-gray-500 mx-2">
                                                <span x-text="fileName || emptyText"></span>
                                                <button x-show="fileName" @click="clearPreview($refs)" type="button" class="remove-image-btn" aria-label="Remove image">
                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="image-preview bg-gray-100">
                                            <div x-show="!previewPhoto">
                                                <svg class="placeholder-icon h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <div x-show="previewPhoto" class="overflow-hidden">
                                                <img :src="previewPhoto" alt="" class="preview-image object-cover" />
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
        <div id="edit-response"></div>
    </div>

    <script>
        document.getElementById("editMemberForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("content-manager/update_member_process.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    document.getElementById("edit-response").innerHTML = data;
                })
                .catch(err => {
                    document.getElementById("edit-response").innerHTML = "<p style='color:red;'>Error saving changes.</p>";
                });
        });
    </script>

</div>