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
if ($userRole !== 'head_admin') {
  // Unauthenticate and redirect non-head_admins to login with error
  session_unset();
  session_destroy();
  header('Location: login.php?error=unauthorized');
  exit;
}
?>

<!DOCTYPE html>

<html>

<head>
  <title>Admin Access</title>
  <link rel="stylesheet" href="Admin.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script
    src="lib/cdn.min.js"
    defer></script>
  <script src="lib/chart.min.js"></script>
  <!-- Bootstrap JS (requires Popper.js) -->
  <script src="lib/cryptojs.min.js"></script>
  <link
    href="lib/bootstrap.min.css"
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
      fb_link,
      img
    ) {
      console.log(count, buttonLabel, id, title, location, date, time, fb_link, img);

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
          const imgPic = document.getElementById("event-img");
          const deleteButton = document.getElementById("btn-delete");
          if (titleField) titleField.value = "";
          if (locationField) locationField.value = "";
          if (dateField) dateField.value = date;
          if (timeField) timeField.value = "";
          if (fbLinkField) fbLinkField.value = "";
          if (deleteButton) deleteButton.style.display = "none"; // Hide delete button for Add
          const imagePreview = document.querySelector('.image-preview');
          if (imagePreview) {
            const placeholderDiv = imagePreview.querySelector('div[x-show="!previewPhoto"]');
            const previewDiv = imagePreview.querySelector('div[x-show="previewPhoto"]');
            if (placeholderDiv && previewDiv) {
              placeholderDiv.style.display = 'block';
              previewDiv.style.display = 'none';
            }
          } // Reset to default image
        }
        if (
          (id != null,
            title != null,
            location != null,
            date != null,
            time != null,
            fb_link != null)
        ) {



          const titleField = document.getElementById("title");
          const locationField = document.getElementById("location");
          const dateField = document.getElementById("date");
          const timeField = document.getElementById("time");
          const fbLinkField = document.getElementById("fb_link");
          const imgPic = document.getElementById("event-img");

          if (titleField) titleField.value = title;
          if (locationField) locationField.value = location;
          if (dateField) dateField.value = date;
          if (timeField) timeField.value = time;
          if (fbLinkField) fbLinkField.value = fb_link;
          if (imgPic) imgPic.src = img;
          const imagePreview = document.querySelector('.image-preview');
          if (imagePreview) {
            const placeholderDiv = imagePreview.querySelector('div[x-show="!previewPhoto"]');
            const previewDiv = imagePreview.querySelector('div[x-show="previewPhoto"]');
            if (placeholderDiv && previewDiv) {
              placeholderDiv.style.display = 'none';
              previewDiv.style.display = 'block';
            }
          }
        }
      }
    }

    function cancel() {
      document.getElementById("popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }

    function hidePopup() {
      document.getElementById("popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>

  <script>
    function toggleBlock(adminId, block) {
      const action = block ? 'block' : 'unblock';
      if (!confirm(`Are you sure you want to ${action} this admin?`)) return;
      fetch('content-manager/block_admin.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${adminId}&block=${block}`
        })
        .then(res => res.text())
        .then(msg => {
          alert(msg);
          location.reload();
        });
    }
  </script>
  <script>
    function openReportTab() {
      const form = document.getElementById('reportForm');
      const table = document.getElementById('tableSelect').value;
      if (!table) {
        alert('Please select a table.');
        return;
      }
      const filters = Array.from(form.querySelectorAll('[name^=filters]')).map(input => {
        if (!input.value) return '';
        return encodeURIComponent(input.name.replace('filters[', '').replace(']', '')) + '=' + encodeURIComponent(input.value);
      }).filter(Boolean).join('&');
      let url = `content-manager/generated_report.php?table=${encodeURIComponent(table)}`;
      if (filters) url += `&${filters}`;
      window.open(url, '_blank');
    }
  </script>
  <script>
    function decrypt() {
      const password = prompt('Enter admin password to decrypt all donor details:');
      if (!password) return;
      const correctPassword = '123'; // Hardcoded password
      if (password !== correctPassword) {
        alert('Incorrect password.');
        return;
      }
      document.querySelectorAll('.masked-data, .donor-name-masked').forEach(function(cell) {
        cell.textContent = cell.getAttribute('data-full');
      });
    }

    function showImagePopup(src) {
      // Create overlay
      const overlay = document.createElement('div');
      overlay.classList.add('image-popup');
      overlay.onclick = function() {
        document.body.removeChild(overlay);
      };
      // Create image
      const img = document.createElement('img');
      img.src = src;
      overlay.appendChild(img);
      document.body.appendChild(overlay);
    }
  </script>
  <script>
    function updates() {
      const form = document.getElementById('userForm');
      const maxSize = 1024 * 1024 * 4; // 4MB limit

      function refreshMembersList() {
        console.log('Refreshing members list...');
        fetch('content-manager/add_member.php?refresh_list=true')
          .then(response => response.text())
          .then(html => {
            document.querySelector('.list').innerHTML = html;
          })
          .catch(error => console.error('Error refreshing members list:', error));
      }

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const fileInput = document.getElementById('profileImage');
        if (fileInput && fileInput.files.length > 0) {
          const file = fileInput.files[0];
          if (file.size > maxSize) {
            document.getElementById('form-response').innerHTML = "<span style='color: red; margin-left:20px;'>❌ Image size exceeds the maximum limit of 4MB.</span>";
            return;
          }
        }

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

        fetch('content-manager/add_member.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.text())
          .then(data => {
            document.getElementById('form-response').innerHTML = data;
            if (data.includes('✅')) {
              form.reset();
              // Reset image preview if using Alpine.js
              const imageUpload = form.querySelector('[x-data]');
              if (imageUpload && imageUpload.__x) {
                imageUpload.__x.$data.previewPhoto = '';
                imageUpload.__x.$data.fileName = null;
              }
              // Refresh the members list
              refreshMembersList();
            }
          })
          .catch(error => {
            console.error('Error:', error);
            document.getElementById('form-response').innerHTML = "<span style='color: red;margin-left:20px;'>❌ An error occurred.</span>";
          });
      });


      /* Add some simple error styling */
      const style = document.createElement('style');
      style.innerHTML = `.input-error { border: 2px solid red !important; }`;
      document.head.appendChild(style);
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
      if (page === "content-manager/dashboard_management.php") {
        // Clear content for Dashboard
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
    function verify() {
      document.querySelectorAll('form[action$="content-manager/verify_donation.php"]').forEach(function(form) {
        form.onsubmit = function(e) {
          e.preventDefault();
          window.open('content-manager/verify_donation.php', 'verifyWindow', 'width=400,height=200');
        };
      });
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
  <script>
    function chart() {
      const ctx = document.getElementById('myChart').getContext('2d');

      const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green'],
          datasets: [{
            label: 'Sample Data',
            data: [12, 19, 3, 5],
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: false, // turn off auto-resize to keep it simple
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
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
              onclick="loadContent('content-manager/dashboard_management.php')">
              <img src="imgs/dashboard.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;"> Dashboard
            </button>
          </h2>
        </div>

        <!-- News Management -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-news">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#newsOptions"
              aria-expanded="false"
              aria-controls="newsOptions">
              <img src="imgs/news.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">News Management
            </button>
          </h2>
          <div
            id="newsOptions"
            class="accordion-collapse collapse"
            aria-labelledby="heading-news"
            data-bs-parent="#adminAccordion">
            <div class="accordion-body">
              <button
                class="btn btn-link"
                type="button"
                onclick="loadContent('content-manager/news_management.php')">
                Add News
              </button>

              <button
                class="btn btn-link"
                type="button"
                onclick="loadContent('content-manager/news_list.php')">
                <img src="imgs/news.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">News List
              </button>
            </div>
          </div>
        </div>

        <!-- Events Management -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-events">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#eventsOptions"
              aria-expanded="false"
              aria-controls="eventsOptions">
              <img src="imgs/events.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Events Management
            </button>
          </h2>
          <div
            id="eventsOptions"
            class="accordion-collapse collapse"
            aria-labelledby="heading-events"
            data-bs-parent="#adminAccordion">
            <div class="accordion-body">
              <button
                class="btn btn-link"
                type="button"
                onclick="loadContent('content-manager/events_management.php')">
                Add Event
              </button>

              <button
                class="btn btn-link"
                type="button"
                onclick="loadContent('content-manager/event_list.php')">
                <img src="imgs/events.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Event List
              </button>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-calendar">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              onclick="loadContent('content-manager/calendar_management.php')">
              <img src="imgs/calendar.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Edit Calendar Events
            </button>
          </h2>
        </div>
        <!-- Calendar Events -->

        <!-- Members Management -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-members">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#membersOptions"
              aria-expanded="false"
              aria-controls="membersOptions">
              <img src="imgs/user.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Members Management
            </button>
          </h2>
          <div
            id="membersOptions"
            class="accordion-collapse collapse"
            aria-labelledby="heading-members"
            data-bs-parent="#adminAccordion">
            <div class="accordion-body">
              <button
                class="btn btn-link"
                type="button"
                onclick="loadContent('content-manager/add_member.php')">
                <img src="imgs/add-user.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Add Member
              </button>

              <button
                class="btn btn-link"
                type="button"
                onclick="loadContent('content-manager/member_list.php')">
                <img src="imgs/user.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Member List
              </button>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-contacts">
            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('content-manager/donation_count.php')">
              <img src="imgs/charity.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Donations Overview
            </button>
          </h2>
        </div>

        <!-- Comments Management -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-comments">
            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('social-manager/comments_admin.php')">
              <img src="imgs/comment.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Feedback Overview
            </button>
          </h2>
        </div>
        <!-- Generate Report -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-calendar">
            <button
              class="accordion-button collapsed no-arrow"
              type="button"
              onclick="loadContent('content-manager/generate.php')">
              <img src="imgs/report.png" alt="Dashboard Icon" style="width:22px;height:22px;margin-right:10px;vertical-align:middle;">Generate Report
            </button>
          </h2>
        </div>
        <!-- Active Admins Management -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-admins">
            <button class="accordion-button collapsed no-arrow" type="button" onclick="loadContent('content-manager/active_admins.php')">
              Active Admins
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
          if (page === "generate.php") {
            showFilters(); // Call showFilters if on generate page


          }
        })
        .catch((error) => console.error("Error loading content:", error));

      currentPage = page;
    }
  </script>

  <script
    src="lib/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>