<!DOCTYPE html>

<html>

<head>
  <title>Bahay Musika - Contacts</title>
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
  <link rel="stylesheet" href="contacts.css" />
  <link rel="stylesheet" href="main-css.css" />
  <link rel="stylesheet" href="scroll.css" />
  <link rel="stylesheet" href="instruments.css" />
  <link rel="stylesheet" href="carousel.css" />
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/ScrollToPlugin.min.js"></script>
  <script src="https://assets.codepen.io/16327/ScrollTrigger.min.js"></script>
  <link rel="prerender" href="/home" />
  <link rel="prerender" href="/contacts" />
  <link rel="prerender" href="/donations" />
  <link rel="prerender" href="/events" />
  <link rel="prerender" href="/news" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");
  </style>
</head>

<body>
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
        <a id="aboutUsClick" href="home.php#about-us">About us</a>
        <a href="events.php">Events</a>
        <a href="news.php">News</a>
        <a href="donation.php">Donation</a>
        <a href="#contacts">Contact Us</a>
      </div>
    </div>
  </nav>
  <div id="homepage" class="main-container"></div>
  <div class="contact_us_6">
    <div class="responsive-container-block container">
      <form class="form-box" method="POST" action="insert_comment.php" onsubmit="return validateContactForm();">
        <div class="container-block form-wrapper">
          <div class="mob-text">
            <p class="text-blk contactus-head">Get in Touch</p>
            <p class="text-blk contactus-subhead">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Felis
              diam lectus sapien.
            </p>
          </div>
          <div class="responsive-container-block" id="i2cbk">
            <div
              class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12"
              id="i10mt-3">
              <p class="text-blk input-title">FIRST NAME</p>
              <input
                class="input"
                id="ijowk-3"
                name="FirstName"
                placeholder="Please enter first name..." required />
            </div>
            <div
              class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12"
              id="ip1yp">
              <p class="text-blk input-title">EMAIL</p>
              <input
                class="input"
                id="ipmgh-3"
                name="Email"
                placeholder="Please enter email..." type="email" required />
            </div>
            <div
              class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12"
              id="ih9wi">
              <p class="text-blk input-title">PHONE NUMBER</p>
              <input
                class="input"
                id="imgis-3"
                name="PhoneNumber"
                placeholder="Please enter phone number..." required />
            </div>
            <div
              class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12"
              id="i634i-3">
              <p class="text-blk input-title">WHAT DO YOU HAVE IN MIND ?</p>
              <textarea
                class="textinput"
                id="i5vyy-3"
                name="Comment"
                placeholder="Please enter query..." required></textarea>
            </div>
          </div>
          <button class="submit-btn" id="w-c-s-bgc_p-1-dm-id-2" type="submit">
            Submit
          </button>
        </div>
      </form>
      <div
        class="responsive-cell-block wk-desk-7 wk-ipadp-12 wk-tab-12 wk-mobile-12"
        id="i772w">
        <div class="map-part">
          <p class="text-blk map-contactus-head" id="w-c-s-fc_p-1-dm-id">
            Reach us at
          </p>
          <p class="text-blk map-contactus-subhead">
            (02) 562 1873 Minstrelrhythmofhopeinc@gmail.com
          </p>

          <div class="social-media-links mob">
            <a
              class="social-icon-link"
              href="https://web.facebook.com/minstrelsrhythmofhopeinc/?__n=K&_rdc=1&_rdr"
              id="ix94i-2-2">
              <img
                class="link-img image-block"
                src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/facebook-app-round-white-icon.png" />
            </a>
            <a
              class="social-icon-link"
              href="https://www.instagram.com/minstrelsrhythmofhope?igsh=MXA3cGF4Mm81ZWZwbg=="
              id="itixd">
              <img
                class="link-img image-block"
                src="https://img.icons8.com/m_outlined/512/FFFFFF/instagram-new.png" />
            </a>

            <a
              class="social-icon-link"
              href="https://www.youtube.com/@minstrelsofhope"
              id="izldf-2-2">
              <img
                class="link-img image-block"
                src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/youtube-app-white-icon.png" />
            </a>
            <a
              class="social-icon-link"
              href="
https://www.tiktok.com/@minstrelsrhythmofhope?_t=8s4noQynngW&_r=1"
              id="izldf-2-2">
              <img
                class="link-img image-block"
                src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/tiktok-round-white-icon.png" />
            </a>
          </div>
          <div class="map-box container-block"></div>
        </div>
      </div>
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
                <form action="">
                  <input type="text" placeholder="Email Address" />
                  <button>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      width="24"
                      height="24">
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" />
                    </svg>
                  </button>
                </form>
              </div>
            </div>

            <div class="layout_item w-25">
              <nav class="c-nav-tool">
                <h4 class="c-nav-tool_title">Menu</h4>
                <ul class="c-nav-tool_list">
                  <li>
                    <a href="about-us" class="c-link">About Us</a>
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
              <ul class="flex">
                <li>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="32"
                    height="32">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M12 6.654a6.786 6.786 0 0 1 2.596 5.344A6.786 6.786 0 0 1 12 17.34a6.786 6.786 0 0 1-2.596-5.343A6.786 6.786 0 0 1 12 6.654zm-.87-.582A7.783 7.783 0 0 0 8.4 12a7.783 7.783 0 0 0 2.728 5.926 6.798 6.798 0 1 1 .003-11.854zm1.742 11.854A7.783 7.783 0 0 0 15.6 12a7.783 7.783 0 0 0-2.73-5.928 6.798 6.798 0 1 1 .003 11.854z" />
                  </svg>
                </li>
                <li>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="32"
                    height="32">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M22 12l-4-4V6l6 6-6 6v-2zm-7.5 1H16v2h-6v-2h1.5V9.9c0-.695-.308-1.349-.835-1.768-.527-.418-1.231-.632-1.935-.632-1.615 0-2.941 1.326-2.941 2.948v5.562h1.5v-4.478c0-.719.665-1.243 1.436-1.243 1.194 0 1.594.775 1.594 1.528v4.218h1.5v-5.343c0-1.145-.867-2.048-1.902-2.048-1.392 0-2.243.96-2.243 2.36v5.306z" />
                  </svg>
                </li>
              </ul>
            </div>

            <div class="layout_item w-50">
              <p class="copy">&copy;2024 Bahay Musika</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script>
    function validateContactForm() {
      var firstName = document.getElementById('ijowk-3').value.trim();
      var email = document.getElementById('ipmgh-3').value.trim();
      var phone = document.getElementById('imgis-3').value.trim();
      var comment = document.getElementById('i5vyy-3').value.trim();
      if (!firstName || !email || !phone || !comment) {
        alert('All fields are required.');
        return false;
      }
      return true;
    }
  </script>
</body>

</html>