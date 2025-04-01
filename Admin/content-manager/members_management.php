<link rel="stylesheet" href="content-manager/css/add_member.css">
<link rel="stylesheet" href="css/add_member.css">

<div id="content" class="dashboard">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
                <div class="member-cont">
                    <img src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-6/481259781_1223400092634847_3204620503352458800_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeHZACEINnBnOrF1DLBqxRv8QLF8AAMgPLVAsXwAAyA8tdpFvBFsXdrJPvv9o0Y_Tq4HjVv6ppFipVjYxAMs4bdJ&_nc_ohc=OXuAr-zpxjgQ7kNvgFI9qKz&_nc_oc=Adnp_Fqk-kPTU9LnMosy_4WufYtviBTnq-Qe4CC_SNPMbQy7ytgH8GVNzdr05dzmWjk&_nc_zt=23&_nc_ht=scontent.fmnl17-5.fna&_nc_gid=mAVXgbpDA1KMgfV_vv5eUw&oh=00_AYFc5oupRmGWfSYedFKjvoaJzb3MivRxv6mmyY2Ngjy66Q&oe=67ED0041" alt="" class="member-img">
                    <div class="member-details">
                        <h3>Dominic G. Casinto</h3>
                        <div class="category-edit-cont">
                            <h5>Alto</h5>

                            <h5 class="edit-button" onclick="loadContent('content-manager/update_member.php')">Edit Member Profile</h5>
                        </div>

                    </div>

                </div>

                <div class="member-cont">
                    <img src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-6/481259781_1223400092634847_3204620503352458800_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeHZACEINnBnOrF1DLBqxRv8QLF8AAMgPLVAsXwAAyA8tdpFvBFsXdrJPvv9o0Y_Tq4HjVv6ppFipVjYxAMs4bdJ&_nc_ohc=OXuAr-zpxjgQ7kNvgFI9qKz&_nc_oc=Adnp_Fqk-kPTU9LnMosy_4WufYtviBTnq-Qe4CC_SNPMbQy7ytgH8GVNzdr05dzmWjk&_nc_zt=23&_nc_ht=scontent.fmnl17-5.fna&_nc_gid=mAVXgbpDA1KMgfV_vv5eUw&oh=00_AYFc5oupRmGWfSYedFKjvoaJzb3MivRxv6mmyY2Ngjy66Q&oe=67ED0041" alt="" class="member-img">
                    <div class="member-details">
                        <h3>Dominic G. Casinto</h3>
                        <div class="category-edit-cont">
                            <h5>Alto</h5>

                            <h5 class="edit-button" onclick="loadContent('content-manager/update_member.php')">Edit Member Profile</h5>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>