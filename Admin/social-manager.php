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
  <title>Admin Access</title>
  <link rel="stylesheet" href="Admin.css" />
  <script
    src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    defer></script>
  <!-- Bootstrap JS (requires Popper.js) -->

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous" />

  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>

  <link rel="stylesheet" href="content-manager/css/event.css" />
  <link rel="stylesheet" href="content-manager/css/update_member.css" />
  <link rel="stylesheet" href="content-manager/css/add_member.css" />
  <link rel="stylesheet" href="content-manager/css/event_management.css" />
  <link
    rel="stylesheet"
    href="content-manager/css/dashboard_management.css" />
  <script>
    function showPopup(
      count,
      buttonLabel,
      id,
      title,
      location,
      date,
      time,
      fb_link
    ) {
      console.log(count, buttonLabel, id, title, location, date, time, fb_link);

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
        if (
          (id != null,
            title != null,
            location != null,
            date != null,
            time != null,
            fb_link != null)
        ) {
          if (count > 1) {

          } else {
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
    }

    function hidePopup() {
      document.getElementById("popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>
  <script>
    function imageData(url) {
      const originalUrl = url || "";
      return {
        previewPhoto: originalUrl,
        fileName: null,
        emptyText: originalUrl ? "No new file chosen" : "No file chosen",
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
        },
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
      "content-manager/dashboard_management.php",
      "content-manager/news_management.php",
      "content-manager/events_management.php",
      "content-manager/calendar_management.php",
      "content-manager/members_management.php",
      "content-manager/homepage_management.php",
      "content-manager/analytics_management.php",
    ];

    pages.forEach(preloadContent);

    window.onload = function() {
      // Load Dashboard on startup
    };
    // Function for AJAX Form Submission
    function submitForm(formId) {
      var form = document.getElementById(formId);
      var formData = new FormData(form);

      // Send the form data via AJAX to the same PHP page (homepage_management.php)
      fetch("content-manager/homepage_management.php", {
          method: "POST",
          body: formData,
        })
        .then((response) => response.text())
        .then((data) => {
          // Insert the result into the content div
          document.getElementById("content").innerHTML = data;
        })
        .catch((error) => console.error("Error submitting form:", error));
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const updateForm = document.getElementById("update-member-form");

      if (updateForm) {
        updateForm.addEventListener("submit", (e) => {
          e.preventDefault();

          const formData = new FormData(updateForm);

          fetch("content-manager/update_member.php", {
              method: "POST",
              body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
              if (data.status === "success") {
                alert(data.message);
                // Optionally reload or update the UI
              } else {
                alert(data.message);
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              alert("An error occurred while updating the member.");
            });
        });
      }
    });
  </script>
</head>

<body>
  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <script src="lib/wow/wow.min.js"></script>
  <div class="navParent">
    <nav>
      <div class="accordion accordion-flush" id="adminAccordion">
        <!-- Dashboard -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-dashboard">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              onclick="loadContent('social-manager/dashboard_management.php')">
              Dashboard
            </button>
          </h2>
        </div>


        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-contacts">
            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('content-manager/donation_count.php')">
              Donations Overview
            </button>
          </h2>
        </div>

        <!-- Comments Management -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-comments">
            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('social-manager/comments_admin.php')">
              Comments Management
            </button>
          </h2>
        </div>
        <!-- Generate Report -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-calendar">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              onclick="loadContent('social-manager/generate.php')">
              Generate Report
            </button>
          </h2>
        </div>
        <button class="accordion-button collapsed no-arrow" type="button" style="color: Red;" onclick="window.location.href='login.php?logout=1'">
          Logout
        </button>
      </div>
    </nav>
  </div>
  <div class="dashboard-parent">
    <div id="content" class="dashboard">
      <div class="intro-cont">
        <h1 class="intro">Welcome to Admin Panel</h1>
      </div>
    </div>
  </div>
  <script>
    function loadContent(page) {
      if (currentPage === page) {
        console.log(`"${page}" is already loaded, skipping reload.`);
        return;
      }

      fetch(page + "?_=" + new Date().getTime()) // bust cache
        .then((response) => response.text())
        .then((data) => {
          document.getElementById("content").innerHTML = data;

          // ✅ Reattach the form handler after loading content
          const form = document.getElementById("userForm");
          const responseBox = document.getElementById("form-response");

          if (form && responseBox) {
            form.addEventListener("submit", function(e) {
              e.preventDefault();
              const formData = new FormData(form);

              fetch(page, {
                  method: "POST",
                  body: formData,
                })
                .then((res) => res.text())
                .then((data) => {
                  responseBox.innerHTML = data;
                  form.reset(); // Optional: reset form
                })
                .catch(() => {
                  responseBox.innerHTML =
                    "<p style='color:red;'>❌ AJAX error occurred.</p>";
                });
            });
          }
        })
        .catch((error) => console.error("Error loading content:", error));

      currentPage = page;
    }
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>