<!DOCTYPE html>

<html>

<head>
  <title>Bahay Musika - Events</title>
  <script type="speculationrules">
    {
        "prerender": [
          {
            "source": "list",
            "urls": [
              "/Bahay-Musika/App-old/home.html",
              "/Bahay-Musika/App-old/home.html/home.html#about-us",
              "/Bahay-Musika/App-old/home.html/contacts.html",
              "/Bahay-Musika/App-old/home.html/donation.html",
              "/Bahay-Musika/App-old/home.html/events.html",
              "/Bahay-Musika/App-old/home.html/news.html"
            ]
          }
        ]
      }
    </script>
  <style>
    /* Hidden by default */
    #popup {
      display: none;
      position: fixed;
      flex-direction: row;
      top: 50%;
      left: 50%;
      height: 60vh;
      width: 80vw;
      justify-content: center;
      align-items: center;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: white;
      border: 2px solid #333;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.71);
      z-index: 10000;
    }

    #eventForm {
      display: flex;
      flex-direction: column;
    }

    #overlay {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    }



    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content h2 {
      margin-top: 0;
    }

    .modal-content label {
      margin-top: 10px;
      font-weight: bold;
    }

    .modal-content input,
    .modal-content button {
      margin-top: 10px;
      padding: 10px;
      font-size: 16px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .modal-content button {
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }

    .modal-content button:hover {
      background-color: #0056b3;
    }

    .event-details {
      font-size: 14px;
      margin-top: 5px;
      color: #333;
    }

    .event-details p {
      margin: 2px 0;
    }

    .event-details {
      color: white
    }

    /* Popup form styles */
    .form-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-title {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    .form-subtitle {
      margin: 5px 0 0 0;
      font-size: 14px;
      color: #777;
    }

    .form-fields {
      height: auto;
      overflow: auto;
      display: flex;
      flex-direction: column;
    }

    .form-fields label {
      margin-top: 10px;
      font-weight: bold;
      color: #333;
    }

    .form-fields input {
      margin-top: 5px;
      padding: 10px;
      font-size: 16px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-fields input::placeholder {
      color: #aaa;
    }

    .form-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .btn-submit {
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
      padding: 10px 20px;
      border-radius: 4px;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .btn-submit:hover {
      background-color: #0056b3;
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
      border: none;
      cursor: pointer;
      padding: 10px 20px;
      border-radius: 4px;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .btn-cancel:hover {
      background-color: #c82333;
    }
  </style>
  <script>
    function showPopup(
      buttonLabel,
      id,
      title,
      location,
      date,
      time,
      fb_link
    ) {

      const popup = document.getElementById("popup");
      const overlay = document.getElementById("overlay");

      console.log(buttonLabel, id, title, location, date, time, fb_link);
      popup.style.display = "flex";
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

    function hidePopup() {
      document.getElementById("popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>
  <style>
    .previous-month {
      color: rgb(179, 179, 179);
    }

    .edit-btn {
      opacity: 0;
      transition: opacity 0.3s;
      position: absolute;
      right: 10px;
      top: 10px;
      background-color: aliceblue;
    }

    .edit-btn {
      padding: 4px 10px;
      font-size: 0.8rem;
      background-color: #eee;
      border: 1px solid #ccc;
      cursor: pointer;
      border-radius: 4px;
    }

    li:hover .edit-btn {
      opacity: 1;
    }
  </style>
  <link rel="icon" href="img/100.jpg" type="image/x-icon" />
  <link rel="prerender" href="/home" />
  <link rel="prerender" href="/contacts" />
  <link rel="prerender" href="/donations" />
  <link rel="prerender" href="/events" />
  <link rel="prerender" href="/news" />
  <link rel="stylesheet" href="event.css" />
  <link rel="stylesheet" href="main-css.css" />
  <script src="antiZoomIn.js"></script>
  <link rel="stylesheet" href="carousel.css" />
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/ScrollToPlugin.min.js"></script>

  <script src="https://assets.codepen.io/16327/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@latest/bundled/lenis.js"></script>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
</head>


<body id="smooth-scroll-wrapper">
  <nav>
    <div class="header">
      <div class="header-hamburgerLogo">
        <a href="#default" class="logo">Bahay Musika</a>

        <div class="header-left">
          <div class="Hamburger">
            <span class="Bar"></span>
            <span class="Bar"></span>
            <span class="Bar"></span>
          </div>
        </div>
      </div>
      <div class="header-right">
        <a class="active" id="homePageClick" href="home.php">Home</a>
        <a href="home.php#about-us">About us</a>
        <a href="#events">Events</a>
        <a href="news.php">News</a>
        <a href="donation.php">Donation</a>
        <a href="contacts.php">Contact Us</a>
      </div>
    </div>
  </nav>
  <div>
    <div id="homepage" class="main-container">
      <div id="events" class="div-container events">
        <div class="row-container">
          <div id="tryingthis" class="try">
            <h1 class="bruh">Projects and Events</h1>
          </div>

          <div class="logo-slide">
            <div class="logos">
              <div class="row1">
                <img class="row-items" src="img/4.jpg" alt="" />
                <img class="row-items" src="img/6.jpg" alt="" />
                <img class="row-items" src="img/7.jpg" alt="" />
                <img class="row-items" src="img/11.jpg" alt="" />
                <img class="row-items" src="img/12.jpg" alt="" />
                <img class="row-items" src="img/16.jpg" alt="" />
                <img class="row-items" src="img/26.jpg" alt="" />
              </div>
              <div class="row1">
                <img class="row-items" src="img/4.jpg" alt="" />
                <img class="row-items" src="img/6.jpg" alt="" />
                <img class="row-items" src="img/7.jpg" alt="" />
                <img class="row-items" src="img/11.jpg" alt="" />
                <img class="row-items" src="img/12.jpg" alt="" />
                <img class="row-items" src="img/16.jpg" alt="" />
                <img class="row-items" src="img/26.jpg" alt="" />
              </div>
            </div>
            <div class="logos">
              <div class="row2">
                <img class="row-items" src="img/20.jpg" alt="" />
                <img class="row-items" src="img/22.jpg" alt="" />
                <img class="row-items" src="img/23.jpg" alt="" />
                <img class="row-items" src="img/26.jpg" alt="" />
                <img class="row-items" src="img/32.jpg" alt="" />
                <img class="row-items" src="img/37.jpg" alt="" />
                <img class="row-items" src="img/40.jpg" alt="" />
              </div>
              <div class="row2">
                <img class="row-items" src="img/20.jpg" alt="" />
                <img class="row-items" src="img/22.jpg" alt="" />
                <img class="row-items" src="img/23.jpg" alt="" />
                <img class="row-items" src="img/26.jpg" alt="" />
                <img class="row-items" src="img/32.jpg" alt="" />
                <img class="row-items" src="img/37.jpg" alt="" />
                <img class="row-items" src="img/40.jpg" alt="" />
              </div>
            </div>
            <div class="logos">
              <div class="row3">
                <img class="row-items" src="img/61.jpg" alt="" />
                <img class="row-items" src="img/62.jpg" alt="" />
                <img class="row-items" src="img/85.jpg" alt="" />
                <img class="row-items" src="img/86.jpg" alt="" />
                <img class="row-items" src="img/4.jpg" alt="" />
                <img class="row-items" src="img/96.jpg" alt="" />
                <img class="row-items" src="img/100.jpg" alt="" />
              </div>
              <div class="row3">
                <img class="row-items" src="img/61.jpg" alt="" />
                <img class="row-items" src="img/62.jpg" alt="" />
                <img class="row-items" src="img/85.jpg" alt="" />
                <img class="row-items" src="img/86.jpg" alt="" />
                <img class="row-items" src="img/4.jpg" alt="" />
                <img class="row-items" src="img/96.jpg" alt="" />
                <img class="row-items" src="img/100.jpg" alt="" />
              </div>
            </div>
          </div>
        </div>
        <div class="body-container">

          <?php
          include_once 'db-connection.php';


          // Get the current date
          $currentDay = date('j');
          $currentMonth = date('n');
          $currentYear = date('Y');

          // Set the calendar to May 2025
          $calendarMonth = 5; // May
          $calendarYear = 2025;

          // Get the first day of the month and the total number of days in the month
          $firstDayOfMonth = mktime(0, 0, 0, $calendarMonth, 1, $calendarYear);
          $totalDaysInMonth = date('t', $firstDayOfMonth);
          $startDayOfWeek = date('w', $firstDayOfMonth); // 0 (Sunday) to 6 (Saturday)

          // Get the previous month and year
          $prevMonth = $calendarMonth - 1;
          $prevYear = $calendarYear;
          if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear--;
          }
          $prevMonthDays = date('t', mktime(0, 0, 0, $prevMonth, 1, $prevYear));
          $prevMonthName = date('F', mktime(0, 0, 0, $prevMonth, 1, $prevYear));

          // Fetch events from the database
          $query = "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as date, time FROM events ORDER BY date ASC";
          $result = $conn->query($query);

          // Create an associative array to group events by date
          $eventsByDate = [];
          while ($row = $result->fetch_assoc()) {
            $eventsByDate[$row['date']][] = $row;
          }
          ?>
          <div class="upcoming-events">

            <h1>May 2025</h1>
            <p class="upcominig-title">Event Calendar</p>
            <ul>
              <?php
              // Print empty days for the first week, filling with previous month's dates
              for ($i = $startDayOfWeek - 1; $i >= 0; $i--) {
                $prevDay = $prevMonthDays - $i;
                echo "<li class='previous-month'> $prevMonthName <time datetime='$prevYear-$prevMonth-$prevDay'>$prevDay</time></li>";
              }

              // Print the days of the month
              for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                $date = sprintf('%04d-%02d-%02d', $calendarYear, $calendarMonth, $day);
                $events = $eventsByDate[$date] ?? [];
                $hasEvent = !empty($events);
                $buttonLabel = $hasEvent ? 'Edit' : 'Add';
                $eventId = $hasEvent ? $events[0]['id'] : null;

                $isToday = ($day == $currentDay && $calendarMonth == $currentMonth && $calendarYear == $currentYear);
                $class = $isToday ? 'class="today"' : '';

                echo "<li $class style='position: relative; overflow: hidden;'>";
                echo "<time>$day</time>";

                if ($hasEvent) {
                  echo "<div class='event-details'>";
                  foreach ($events as $event) {
                    echo "<p style = \"font-size: 17px;\"><strong>{$event['title']}</strong> </ps>";
                    $formattedTime = date('h:i A', strtotime($event['time']));
                    echo "<p><strong></strong> $formattedTime</p>";
                  }
                  echo "</div>";
                  echo "<button class='edit-btn' onclick=\"showPopup();\" >View</button>";
                } else {

                  echo "</li>";
                }
              }
              ?>

            </ul>
          </div>
          <div id="overlay" onclick="hidePopup()"></div>
          <div id="popup" class="modal-content">
            <div id="eventForm" enctype="multipart/form-data">
              <div class="form-header">
                <h2 class="form-title">Add/Edit Event</h2>
                <p class="form-subtitle">Fill out the details below</p>
              </div>

              <div class="form-fields">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Event Title" required>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Event Location" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <label for="fb_link">Facebook Link:</label>
                <input type="text" id="fb_link" name="fb_link" placeholder="Facebook Event Link">

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <label for='image-preview'>Image Preview:</label>
                <img id='image-preview' src='' alt='Event Image' style='max-width: 100%; height: auto; margin-top: 10px; display: none;'>
              </div>

              <div class="form-buttons">
                <button type="submit" class="btn-submit">Save</button>
                <button type="button" class="btn-cancel" onclick="hidePopup()">Cancel</button>
              </div>
            </div>
          </div>
          <div class="event-description-list-wrap">
            <div class="event-description-list">
              <div class="container-desc">
                <div class="slick-track" style="opacity: 1">
                  <div class="container-desc-per icymi">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-icymi">October 19 2024</span>
                        <p class="event-title event-title-icymi">
                          ICYMI:
                          <i>The capabilities building program and values
                            formation program 'Film Viewing'
                          </i>
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-icymi">
                            <p>Bahay Musika Building</p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-icymi">
                          An annual film viewing for the beneficiaries of the
                          organization as they watched the film “Lolo and the
                          kid directed by Benedict Mique” that centers around
                          an old man to a child and their remarkable
                          connections to each other.
                        </p>
                        <div class="event-img event-img-icymi">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-desc-per baton">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-baton">August 31 2024
                        </span>
                        <p class="event-title event-title-baton">
                          Under the baton:
                          <i>The Anthony Villanueva music festival </i>
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-baton">
                            <p>
                              Tanghalang yaman lahi, Emilio Aguinaldo College
                            </p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-baton">
                          Minstrels of hope headed by their musical director,
                          Mr Anthony Go Villanueva performed the piece CIkala
                          Le Pong Pong, arranged by Ken Steven
                        </p>
                        <div class="event-img event-img-baton">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-desc-per sagip">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-sagip">July 27 2024</span>
                        <p class="event-title event-title-sagip">
                          Benildean operation sagip:

                          <i>Bagyong Carina </i>
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-sagip">
                            <p>Benilde Center for Social Action</p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-sagip">
                          Donations through relief packs for the victims of
                          bagyong Carina given to the organization with the
                          help of Benildeans.
                        </p>
                        <div class="event-img event-img-sagip">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-desc-per school">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-school">July 21 2024</span>
                        <p class="event-title event-title-school">
                          Back to school program 2024

                          <i>
                            “Bayanihan sa bahay musika, tungo sa masayang
                            balik eskwela”</i>
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-school">
                            <p>Silahis ng Karunungan Ppecial School</p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-school">
                          Donation of school supplies and other school
                          essentials for the disabled children to equip the
                          students for their very exciting return to school
                        </p>
                        <div class="event-img event-img-school">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-desc-per pray">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-pray">March 17 2024
                        </span>
                        <p class="event-title event-title-pray">
                          Prayer and Contemplation
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-pray">
                            <p>Barangay 825 Zone 89 Saint Teri Chapel</p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-pray">
                          To help our beneficiaries to acknowledge god's
                          presence and keep their eyes on him by engaging
                          their hearts and mind
                        </p>
                        <div class="event-img event-img-pray">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-desc-per values">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-values">November 27 2023</span>
                        <p class="event-title event-title-values">
                          Values Formation
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-values">
                            <p>Barangay 828 Zone 89 Paco Manila</p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-values">
                          Celebrating children's month by promoting a child's
                          well being. Highlights the importance of insuring
                          every child has an access to proper nutrition and a
                          safe living environment
                        </p>
                        <div class="event-img event-img-values">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-desc-per hiv">
                    <div class="event-description-item slick-slide">
                      <div class="time">
                        <span class="date-label date-label-hiv">June 2 2024</span>
                        <p class="event-title event-title-hiv">
                          Reproductive Health and HIV Awareness
                        </p>
                        <div class="date-cont">
                          <span class="location-label location-label-hiv">
                            <p>Merced St. Paco Manila</p>
                            <div class="rectangle"></div>
                          </span>
                        </div>
                        <p class="event-detail event-detail-hiv">
                          The purpose of this seminar was to educate the
                          people on how to prevent HIV by altering their
                          sexual behavior , as well as to promote positive
                          attitudes and increased comfort with one's
                          sexualities.
                        </p>
                        <div class="event-img event-img-hiv">
                          <img
                            src="img/11.jpg"
                            alt=""
                            class="img img-icymi img-1" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-2" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-3" />
                          <img
                            src="img/12.jpg"
                            alt=""
                            class="img img-icymi img-4" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-container">
          <div class="carousel-items">
            <div id="trial" class="carousel-item"></div>
            <div class="carousel-item">ICYMI</div>
            <div class="carousel-item">Under the Baton</div>
            <div class="carousel-item">Benildean Operation Sagip</div>
            <div class="carousel-item">Back to School Program 2024</div>
            <div class="carousel-item">Prayer and Contemplation</div>
            <div class="carousel-item">Values Formation</div>
            <div class="carousel-item">HIV Awareness</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const container = document.querySelector(".carousel-container");
      const carouselCont = document.querySelector(".carousel-items");

      const items = document.querySelector(".carousel-items");
      const itemHeight =
        document.querySelector(".carousel-item").offsetHeight;
      const itemsData = [
        "icymi",
        "baton",
        "sagip",
        "school",
        "pray",
        "values",
        "hiv",
      ];

      let currentIndex = 1;
      let isScrolling = false;
      let autoScrollInterval = null;
      let delayTimeout;
      let isClicked = false;
      let mouseDownTime = 0;
      let isMouseDown = false;
      let isAutoScrolling = false;

      const carouselItems = document.querySelectorAll(".carousel-item");

      let isFollowing = false;

      // Scroll lock logic
      let isScrollLocked = false;

      carouselCont.addEventListener("mouseenter", () => {});

      carouselCont.addEventListener("mouseleave", () => {
        document.body.classList.remove("scroll-locked");
      });

      carouselItems.forEach((item, index) => {
        item.addEventListener("mouseover", (event) => {
          const hoveredItem = event.currentTarget;
          const itemText = hoveredItem.textContent || "No Text";
          const isHighlightedFollow =
            hoveredItem.classList.contains("highlighted");

          document.addEventListener("mousemove", moveImage);
        });

        item.addEventListener("mouseleave", () => {
          isClicked = false;
          isFollowing = false;

          setTimeout(() => {
            if (!isFollowing) {
              // Additional logic if needed
            }
          }, 200);
        });
      });

      function moveImage(e) {
        if (isFollowing) {
          const targetX = e.pageX;
          const targetY =
            e.pageY + document.documentElement.clientHeight * 0.1;
          requestAnimationFrame(() => {});
        }
      }

      const updateCarousel = () => {
        Array.from(items.children).forEach((child) =>
          child.classList.remove("highlighted")
        );

        items.children[currentIndex].classList.add("highlighted");

        const defaultTranslationValueVh = 70;
        const highlightedItem = items.children[currentIndex];
        const highlightedItemTop = highlightedItem.offsetTop;
        const firstVisibleItem = items.children[1];
        const firstItemTop =
          firstVisibleItem.offsetTop + firstVisibleItem.clientHeight / 2;

        const adjustmentValueVh =
          ((highlightedItemTop +
              highlightedItem.clientHeight / 2 -
              firstItemTop) /
            window.innerHeight) *
          100;
        const finalTranslationValueVh =
          defaultTranslationValueVh - adjustmentValueVh;

        items.style.transform = `translateY(${finalTranslationValueVh}vh)`;

        itemsData.forEach((key, index) => {
          const isHighlighted =
            items.children[index + 1]?.classList.contains("highlighted");
          const selectors = [
            `.date-label-${key}`,
            `.location-label-${key}`,
            `.event-detail-${key}`,
            `.event-title-${key}`,
            `.event-img-${key}`,
          ];

          selectors.forEach((selector) => {
            const element = document.querySelector(selector);
            if (element) element.classList.toggle("active", isHighlighted);
          });
        });
      };

      items.addEventListener("mousedown", () => {
        isMouseDown = true;

        mouseDownTimeout = setTimeout(() => {
          isMouseDown = false;
        }, 300);
      });

      items.addEventListener("mouseup", () => {
        clearTimeout(mouseDownTimeout); // Clear the timeout
        isMouseDown = false; // Reset mouse down state
      });

      const nextItem = () => {
        currentIndex = (currentIndex + 1) % items.children.length;

        if (currentIndex === 0) {
          currentIndex = 1;
        }
        updateCarousel();
      };

      const prevItem = () => {
        currentIndex =
          (currentIndex - 1 + items.children.length) % items.children.length;

        if (currentIndex === 0) {
          currentIndex = 7;
        }
        updateCarousel();
      };

      const handleScroll = (event) => {
        if (!isScrolling) {
          event.deltaY > 0 ? nextItem() : prevItem();
          isScrolling = true;
          setTimeout(() => (isScrolling = false), 2000);
          restartAutoScroll();
        }
        event.preventDefault();
      };

      const handleClick = (index) => {
        clearTimeout(delayTimeout);
        delayTimeout = setTimeout(() => {
          currentIndex = index;
          updateCarousel();
        }, 100);
        restartAutoScroll();
      };

      const restartAutoScroll = () => {
        clearInterval(autoScrollInterval);
        autoScrollInterval = setInterval(nextItem, 6000);
        isAutoScrolling = true;
      };

      const handleHover = () => clearInterval(autoScrollInterval);
      const handleMouseOut = () => restartAutoScroll();

      document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
          clearInterval(autoScrollInterval);
          isAutoScrolling = false;
        } else {
          restartAutoScroll();
        }
      });

      const handleTransitionEnd = () => {};

      updateCarousel();
      items.children[0].classList.add("highlighted");
      items.addEventListener("transitionend", handleTransitionEnd);
      container.addEventListener("wheel", handleScroll);

      Array.from(items.children).forEach((child, index) => {
        child.addEventListener("click", () => handleClick(index));
        child.addEventListener("mouseover", handleHover);
        child.addEventListener("mouseout", handleMouseOut);
      });

      const startAutoScroll = () => {
        if (!isAutoScrolling) {
          isAutoScrolling = true;
          autoScrollInterval = setInterval(nextItem, 6000);
        }
      };

      const stopAutoScroll = () => {
        clearInterval(autoScrollInterval);
        isAutoScrolling = false;
      };

      const observerOptions = {
        root: null,
        threshold: 0.7,
      };

      const observerCallback = (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            startAutoScroll();
            if (currentIndex === 0) {
              currentIndex = 1;
              updateCarousel();
            }
          } else {
            stopAutoScroll();
          }
        });
      };

      const observer = new IntersectionObserver(
        observerCallback,
        observerOptions
      );

      observer.observe(container);
    });
    const hamburger = document.querySelector(".Hamburger");
    const navMenu = document.querySelector(".header-right");

    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  </script>
</body>

</html>