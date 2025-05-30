<?php
include 'db-connection.php';
?>

<link rel="stylesheet" href="content-manager/css/add_member.css">
<link rel="stylesheet" href="css/add_member.css">
<style>
    .members-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        height: 100%;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-left: 0px;
    }

    .member-cont {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .member-cont:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .member-img {
        width: 60px;
        height: 60px;
        border-radius: 10%;
        object-fit: cover;
        border: 2px solid #ddd;
        margin-right: 0px;
    }

    .member-details {
        flex: 1;
    }

    .member-details h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .category-edit-cont {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
    }

    .category-edit-cont h5 {
        margin: 0;
        font-size: 14px;
        color: #666;
    }

    .edit-button {
        cursor: pointer;
        color: #007bff;
        text-decoration: underline;
        font-size: 14px;
        color: white;
    }

    .edit-button:hover {
        color: #0056b3;
    }
</style>
<div id="content" class="dashboard">
    <script src="../lib/alpinejs.min.js" defer></script>

    <link rel="stylesheet" href="../Admin.css" />
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
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Update Choir Member Profile</h3>

    <div class="main-cont">

        <div class="members-list">

            <h2 class="member-title">Members List</h2>
            <div class="list">
                <?php
                $result = $conn->query("SELECT * FROM members");
                if ($result->num_rows > 0):
                    while ($user = $result->fetch_assoc()): ?>
                        <div class="member-cont">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($user['profile_image']) ?>" alt="Profile" class="member-img">
                            <?php else: ?>
                                <div class="member-img placeholder">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="member-details">
                                <h3><?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?></h3>
                                <h5><?= htmlspecialchars($user['category']) ?></h5>


                            </div>
                            <h5 class="edit-button" onclick="loadContent('content-manager/update_member.php?id=<?= $user['id'] ?>')">Edit Member Profile</h5>

                        </div>
                <?php endwhile;
                endif; ?>
            </div>
        </div>

    </div>

</div>