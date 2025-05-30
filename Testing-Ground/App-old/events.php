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
      flex-direction: column;
      top: 50%;
      left: 50%;
      height: 60vh;

      justify-content: center;
      align-items: center;
      transform: translate(-50%, -50%);




      z-index: 10000;
    }

    #eventForm {
      display: flex;
      width: 100%;
      flex-direction: row;
      justify-content: center;

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

      padding: 20px;
      border-radius: 8px;


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
      fb_link,
      description = '',
      image = ''
    ) {
      const popup = document.getElementById("popup");
      const overlay = document.getElementById("overlay");
      popup.style.display = "flex";
      overlay.style.display = "block";

      // Professional event card layout
      let html = `
        <div style="display: flex; flex-direction: column; align-items: center; max-width: 500px; width: 100%;">
          <button onclick=\"hidePopup()\" style='align-self: flex-end; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #333;' title='Close'>&times;</button>
          <div style='width: 100%; background: #f7f7f7; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 24px 20px 20px 20px; display: flex; flex-direction: column; align-items: center;'>
            ${image ? `<img src='${image}' alt='${title}' style='width: 100%; max-width: 320px; border-radius: 8px; margin-bottom: 18px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.10);' />` : ''}
            <h2 style='margin: 0 0 10px 0; color: #1a237e; font-family: Montserrat, sans-serif; font-size: 2rem; text-align: center;'>${title}</h2>
            <div style='color: #333; font-size: 1.1rem; margin-bottom: 10px; text-align: center;'>
              <span style='font-weight: 500;'>${date}</span> &bull; <span style='font-weight: 500;'>${time}</span>
            </div>
            <div style='color: #555; font-size: 1rem; margin-bottom: 10px; text-align: center;'>
              <span style='font-weight: 500;'>Location:</span> ${location}
            </div>
            ${description ? `<div style='color: #444; font-size: 1rem; margin-bottom: 12px; text-align: center;'>${description}</div>` : ''}
            ${fb_link && fb_link !== 'null' ? `<a href='${fb_link}' target='_blank' style='display: inline-block; margin-top: 10px; background: #1877f2; color: #fff; padding: 10px 22px; border-radius: 5px; text-decoration: none; font-weight: 500; transition: background 0.2s;'>View on Facebook</a>` : ''}
          </div>
        </div>
      `;
      popup.innerHTML = html;
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
                    $eventTitle = htmlspecialchars($event['title']);
                    $eventLocation = htmlspecialchars($event['location']);
                    $eventDate = htmlspecialchars($event['date']);
                    $eventTime = date('h:i A', strtotime($event['time']));
                    $eventFbLink = htmlspecialchars($event['fb_link']);
                    $eventDesc = isset($event['description']) ? htmlspecialchars($event['description']) : '';
                    $eventImage = !empty($event['image']) ? 'data:' . $event['image_type'] . ';base64,' . base64_encode($event['image']) : '';
                    echo "<p style = \"font-size: 17px;\"><strong>{$eventTitle}</strong> </p>";
                    echo "<p><strong></strong> $eventTime</p>";
                    // Pass all details to showPopup
                    echo "<button class='edit-btn' onclick=\"showPopup('View', '{$eventId}', '{$eventTitle}', '{$eventLocation}', '{$eventDate}', '{$eventTime}', '{$eventFbLink}', '{$eventDesc}', '{$eventImage}')\" >View</button>";
                  }
                  echo "</div>";
                } else {
                  echo "</li>";
                }
              }
              ?>

            </ul>
          </div>
          <div id="overlay" onclick="hidePopup()"></div>
          <div id="popup" class="modal-content">

          </div>
          <?php
          // Fetch events for carousel from database
          $carouselQuery = "SELECT *, DATE_FORMAT(date, '%M %d %Y') as formatted_date FROM events ORDER BY date DESC LIMIT 10";
          $carouselResult = $conn->query($carouselQuery);
          $carouselEvents = [];
          while ($row = $carouselResult->fetch_assoc()) {
            $carouselEvents[] = $row;
          }
          ?>

          <div class="event-description-list-wrap">
            <div class="event-description-list">
              <div class="container-desc">
                <div class="slick-track" style="opacity: 1">
                  <?php foreach ($carouselEvents as $index => $event):
                    $eventKey = 'event_' . $event['id'];
                    $formattedTime = date('h:i A', strtotime($event['time']));
                    $imageData = base64_encode($event['image']);
                    $formattedDate = date('F j, Y', strtotime($event['date']));
                    $imageSrc = 'data:' . $event['image_type'] . ';base64,' . $imageData;
                  ?>
                    <div class="container-desc-per <?php echo $eventKey; ?>">
                      <div class="event-description-item slick-slide">
                        <div class="time">
                          <span class="event-date-label event-date-label-<?php echo $eventKey; ?>"><?php echo $formattedDate; ?></span>
                          <p class="event-title event-title-<?php echo $eventKey; ?>">
                            <?php echo htmlspecialchars($event['title']); ?>
                          </p>
                          <div class="event-date-cont">
                            <span class="location-label location-label-<?php echo $eventKey; ?>">
                              <p><?php echo htmlspecialchars($event['location']); ?></p>
                              <div class="rectangle"></div>
                            </span>
                          </div>
                          <p class="event-detail event-detail-<?php echo $eventKey; ?>">
                            Event scheduled for <?php echo $formattedTime; ?> at <?php echo htmlspecialchars($event['location']); ?>.
                            <?php if (!empty($event['fb_link'])): ?>
                              <a href="<?php echo htmlspecialchars($event['fb_link']); ?>" class="fb_link" target="_blank">View on Facebook</a>
                            <?php endif; ?>
                          </p>
                          <div class="event-img event-img-<?php echo $eventKey; ?>">
                            <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="img img-<?php echo $eventKey; ?> img-1" />

                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-container">
          <div class="carousel-items">
            <div id="trial" class="carousel-item"></div>
            <?php foreach ($carouselEvents as $index => $event): ?>
              <div class="carousel-item"><?php echo htmlspecialchars($event['title']); ?></div>
            <?php endforeach; ?>
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

      // Dynamic itemsData based on PHP events
      const itemsData = [
        <?php
        $jsEventKeys = [];
        foreach ($carouselEvents as $event) {
          $jsEventKeys[] = '"event_' . $event['id'] . '"';
        }
        echo implode(',', $jsEventKeys);
        ?>
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

        const highlightedItem = items.children[currentIndex];
        const highlightedItemCenter =
          highlightedItem.offsetTop + highlightedItem.clientHeight / 2;

        const verticalOffset = 300; // pixels higher than center
        const screenCenter = window.innerHeight / 2 - verticalOffset;

        const adjustmentValueVh =
          ((highlightedItemCenter - screenCenter) / window.innerHeight) * 100;

        const finalTranslationValueVh = -adjustmentValueVh;

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
  <footer class="footer">
    <video
      class="footer_video"
      muted=""
      loop=""
      autoplay
      src="//cdn.shopify.com/s/files/1/0526/6905/5172/t/5/assets/footer.mp4?v=29581141968431347981633714450"
      type="video/mp4"></video>

    <div class="container">
      <div class="footer_inner">
        <div class="c-footer">
          <div class="layout">
            <div class="layout_item w-50">
              <div class="newsletter">
                <h3 class="newsletter_title">
                  Get updates on fun stuff you probably want to know about in
                  your inbox.
                </h3>

              </div>
            </div>

            <div class="layout_item w-25">
              <nav class="c-nav-tool">
                <h4 class="c-nav-tool_title">Menu</h4>
                <ul class="c-nav-tool_list">
                  <li>
                    <a href="#about-us" class="c-link">About Us</a>
                  </li>

                  <li>
                    <a href="events" class="c-link">Events</a>
                  </li>

                  <li>
                    <a href="news" class="c-link">News</a>
                  </li>
                  <a href="donation" class="c-link">Donation</a>
                  <li>
                    <a href="#" class="c-link"></a>
                  </li>
                </ul>
              </nav>
            </div>

            <div class="layout_item w-25">
              <nav class="c-nav-tool">
                <h4 class="c-nav-tool_title">Contact Us</h4>
                <ul class="c-nav-tool_list">
                  <li class="c-nav-tool_item">
                    <a href="email" class="c-link">Email</a>
                  </li>

                  <li class="c-nav-tool_item">
                    <a
                      href="https://www.instagram.com/minstrelsrhythmofhope?igsh=MXA3cGF4Mm81ZWZwbg=="
                      class="c-link">Instagram</a>
                  </li>

                  <li class="c-nav-tool_item">
                    <a
                      href="https://www.youtube.com/@minstrelsofhope"
                      class="c-link">Youtube</a>
                  </li>

                  <li class="c-nav-tool_item">
                    <a
                      href="https://www.instagram.com/minstrelsrhythmofhope?igsh=MXA3cGF4Mm81ZWZwbg=="
                      class="c-link">Tiktok</a>
                  </li>

                  <li class="c-nav-tool_item">
                    <a
                      href="https://web.facebook.com/minstrelsrhythmofhopeinc/?__n=K&_rdc=1&_rdr"
                      class="c-link">Facebook</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="layout c-2">
            <div class="layout_item w-50">

            </div>

            <div class="layout_item w-50">
              <p class="copy">&copy;2024 Bahay Musika</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>