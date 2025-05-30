<!DOCTYPE html>

<html>

<head>
  <title>Bahay Musika - News</title>
  <link
    rel="icon"
    href="https://scontent.fmnl17-4.fna.fbcdn.net/v/t39.30808-6/326550258_1211873573075989_6677191777421434541_n.png?_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeE6Urt2xxcxoLN8MjGWaK1K_DUXngsHECb8NReeCwcQJvRQ_toAsM5tsfVUWOQGNwfSWmpHmXy7nJB9cZoOvIDo&_nc_ohc=KZTZvuXVbMQQ7kNvgEsQxgG&_nc_zt=23&_nc_ht=scontent.fmnl17-4.fna&_nc_gid=AGbVG-ASeBS2vQfqePKkcRX&oh=00_AYCcaHCKgb-d8RBvxut-kIycO77cVquYY86DHb1wc8TodA&oe=675D887B"
    type="image/x-icon" />
  <script type="speculationrules">
    {
        "prerender": [
          {
            "source": "list",
            "urls": [
              "/Bahay-Musika/App/home",
              "/Bahay-Musika/App/home#about-us",
              "/Bahay-Musika/App/contacts",
              "/Bahay-Musika/App/donation",
              "/Bahay-Musika/App/events",
              "/Bahay-Musika/App/news"
            ]
          }
        ]
      }
    </script>
  <link rel="stylesheet" href="main-css.css" />
  <link rel="stylesheet" href="carousel.css" />
  <script src="antiZoomIn.js"></script>
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
        <a href="events.php">Events</a>
        <a href="#news">News</a>
        <a href="donation.php">Donation</a>
        <a href="contacts.php">Contact Us</a>
      </div>
    </div>
  </nav>
  <div>
    <div id="homepage" class="main-container">
      <div id="news" class="div-container news">
        <div class="page-title-cont">
          <div class="page-title">
            <h1 class="title-front">News & Article</h1>
            <h1 class="title-back">BLOG</h1>
          </div>
        </div>
        <section id="horizontal">
          <div class="container">
            <div class="news-content">
              <?php
              include_once 'db-connection.php';
              $query = "SELECT id, title, content, location, date, time, fb_link, image, image_type FROM news ORDER BY date DESC, id DESC";
              $result = $conn->query($query);
              if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                  $imageData = base64_encode($row['image']);
                  $imageType = $row['image_type'];
                  $imageSrc = $imageData ? "data:$imageType;base64,$imageData" : '';
                  $title = htmlspecialchars($row['title']);
                  $desc = htmlspecialchars($row['content']);
                  $location = htmlspecialchars($row['location']);
                  $date = $row['date'] ? date('F j, Y', strtotime($row['date'])) : '';
                  $time = $row['time'] ? date('h:i A', strtotime($row['time'])) : '';
                  $fb_link = htmlspecialchars($row['fb_link']);
              ?>
                  <div class="news-items">
                    <div class="news-item">
                      <div class="news-img">
                        <?php if ($imageSrc): ?>
                          <img class="news-img-item" src="<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>" />
                        <?php endif; ?>
                      </div>
                      <div class="news-cont">
                        <div class="top-news-paragraph">
                          <p class="news-title"><?php echo $title; ?></p>
                          <div class="desc">
                            <p class="news-desc"><?php echo $desc; ?></p>
                          </div>

                        </div>
                        <div class="bottom-news-paragraph">
                          <?php if ($fb_link): ?>
                            <a class="read-more" href="<?php echo $fb_link; ?>" target="_blank">Read more</a>
                          <?php endif; ?>
                          <p class="news-date"><?php echo $date; ?><?php if ($time) echo ' &bull; ' . $time; ?></p>
                          <?php if ($location): ?>
                            <p class="news-location" style="color:#888;font-size:0.95em;margin:0;">Location: <?php echo $location; ?></p>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endwhile;
              else: ?>
                <div style="padding: 2em; text-align: center; color: #888;">No news available.</div>
              <?php endif; ?>
            </div>
          </div>
        </section>
      </div>
    </div>
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
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const element = document.querySelector(".news-img-item");

      if (element) {
        element.addEventListener("mouseenter", () => {
          console.log("try bruh");
          gsap.to(element, {
            scale: 1.3,
            duration: 0.3,
          });
        });

        element.addEventListener("mouseleave", () => {
          gsap.to(element, {
            scale: 1,
            duration: 0.3,
          });
        });
      } else {
        console.error("Element with class 'news-img-item' not found.");
      }
    });
  </script>
  <script>
    const section_2 = document.getElementById("horizontal");
    let box_items = gsap.utils.toArray(".news-item");

    gsap.to(box_items, {
      xPercent: -100 * (box_items.length - 1),
      ease: "sine.out",
      scrollTrigger: {
        trigger: section_2,
        pin: true,
        scrub: 3,
        snap: 1 / (box_items.length - 1),
        end: "+=" + section_2.offsetWidth,
      },
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