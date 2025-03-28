<!DOCTYPE html>

<html>

<head>
  <link rel="stylesheet" href="Admin.css" />

  <title>Admin Access</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
  <script>
    function loadContent(page) {
      fetch(page)
        .then(response => response.text())
        .then(data => {
          document.getElementById("content").innerHTML = data;
        })
        .catch(error => console.error('Error loading content:', error));
    }
  </script>
</head>

<body>
  <div class="navParent">
    <nav>
      <div class="profile">
        <div class="profile-cont">
          <img
            class="profile-picture"
            src="https://scontent.fmnl17-4.fna.fbcdn.net/v/t39.30808-6/474540348_1188926739415516_8310956576555424022_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeH5bWPzRwfO9IZZz1wIOb9lioyvj5V9nHCKjK-PlX2ccA9-t0sN-llSfD5iuTx5-05rJvizDoEhcSeGWwJZK22l&_nc_ohc=uI2EpYfTWyQQ7kNvgF7zvoH&_nc_oc=Adj_IcWjyhD2_DNsneS2SXEG6bYRmdjqk0P04wsLSDCk6ROgGT0cLyFIrtSrgs52-_Q&_nc_zt=23&_nc_ht=scontent.fmnl17-4.fna&_nc_gid=AbRcE4m7cR78TSCZycK1nEL&oh=00_AYAiDk_5mbCVszBn3wby9R-J5yI2iy0je0JdTlz6k_BgvQ&oe=67A88FE9"
            alt="" />
          <div class="admin-profile-cont">
            <h1 class="admin-title">Admin Profile</h1>
            <h2 class="admin-status">Active</h2>
          </div>
        </div>
      </div>
      <div class="navigation_buttons">
        <button class="nav_button" onclick="loadContent('content-manager/dashboard_management.php')">
          <h1 class="nav_buttons">Dashboard</h1>
        </button>
        <button class="nav_button" onclick="loadContent('content-manager/news_management.php')">
          <h1 class="nav_buttons">News Management</h1>
        </button>
        <button class="nav_button" onclick="loadContent('content-manager/events_management.php')">
          <h1 class="nav_buttons">Events Management</h1>
        </button>
        <button class="nav_button" onclick="loadContent('content-manager/calendar_management.php')">
          <h1 class="nav_buttons">Calendar Events</h1>
        </button>
        <button class="nav_button" onclick="loadContent('content-manager/members_management.php')">
          <h1 class="nav_buttons">Members Management</h1>
        </button>
        <button class="nav_button" onclick="loadContent('content-manager/homepage_management.php')">
          <h1 class="nav_buttons">Homepage Content</h1>
        </button>
        <button class="nav_button" onclick="loadContent('content-manager/analytics_management.php')">
          <h1 class="nav_buttons">Reports & Analytics</h1>
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
</body>

</html>