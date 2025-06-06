<!DOCTYPE html>

<html>

<head>
  <title>Bahay Musika - Donation</title>
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
  <link rel="stylesheet" href="main-css.css" />
  <link rel="stylesheet" href="donation.css" />
  <script src="antiZoomIn.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/ScrollToPlugin.min.js"></script>
  <script src="https://assets.codepen.io/16327/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@latest/bundled/lenis.js"></script>
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
  <style>
    body {
      background-color: #121212;
      color: #ffffff;
      font-family: 'Poppins', sans-serif;
    }

    .header,
    .footer {
      background-color: #1f1f1f;
    }

    .input-name,
    .input-price {
      background-color: #1f1f1f;
      color: #ffffff;
      border: 1px solid #ffffff;
    }

    .continue-button {
      background-color: #4caf50;
      color: #ffffff;
      border: none;
      padding: 15px 30px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .cancel-button {
      background-color: #f44336;
      color: #ffffff;
      border: none;
      padding: 15px 30px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .donation-message {
      margin-top: 10px;
      padding: 10px;
      border-radius: 5px;
      display: none;
    }

    .donation-message.success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      display: block;
    }

    .donation-message.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
      display: block;
    }

    .loading {
      opacity: 0.6;
      pointer-events: none;
    }
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
        <a href="news.php">News</a>
        <a href="#donation">Donation</a>
        <a href="contacts.php">Contact Us</a>
      </div>
      <div class="header-left"></div>
    </div>
  </nav>
  <div>
    <div id="homepage" class="main-container">
      <div id="donation" class="div-container donation">
        <div class="donation-introduction">
          <div class="donation-raised">
            <div class="money-raised-cont">
              <div class="money-raised">
                <h1 class="raise-text">
                  CHANGE THE LIFE OF THOSE,<br />
                  WHO HAVE NO <b class="change-color">HOPE</b>
                </h1>
                <h3 class="second-text">
                  be the reason someone smiles today
                </h3>
              </div>
            </div>
            <div class="context-cont">
              <div class="context-text-cont">
                <h1 class="context-title">LET'S MAKE A DIFFERENCE TODAY</h1>
                <p class="context-paragraph">
                  When you give, you're not just helping someone in
                  need—you're creating a ripple of hope, kindness, and
                  possibility. Every donation, big or small, brings us closer
                  to a world where compassion knows no bounds. Together, we
                  can make a lasting impact—one act of generosity at a time.
                </p>
              </div>
              <div class="context-img">
                <img class="img-context" src="img/donation/poor.jpg" alt="" />
              </div>
            </div>
          </div>

          <div class="donation-gallery">
            <div class="proofs">
              <h2 class="funds-title">
                With the help of our sponsors, we have raised over
              </h2>
              <h1 class="funds">₱ 1,200,000</h1>
            </div>
            <div class="donation-img-cont">
              <img
                src="img/donation/donation cont/1.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/2.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/3.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/4.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/5.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/6.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/7.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/8.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/9.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/10.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/11.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/12.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/13.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/14.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/15.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/16.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/17.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/18.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/19.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
              <img
                src="img/donation/donation cont/20.jpg"
                alt=""
                loading="lazy"
                decoding="async"
                class="img-item" />
            </div>
          </div>

          <div class="donation-box">
            <div class="donation-mode">
              <div class="donation-bpi">
                <div class="donation-bpi-title">
                  <h1>BPI Instruction</h1>
                </div>
                <div class="donation-bpi-instruction">
                  <div class="instruction">
                    <h3>Login in to BPI and tap Pay QR</h3>
                    <h3>Scan our QR code</h3>
                    <h3>Input the total amount and tap Next</h3>
                    <h3>Review all details then tap on Pay</h3>
                  </div>
                  <img
                    class="bpi-qr"
                    src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t1.15752-9/462652569_566505656131089_5671771928665512710_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFQDyt_zKObKstooFhVYtbqFIUmPFZDa28UhSY8VkNrb9NC0CvK-nzAOIH3mO_l-C4vmjySiPu3DL-VMBzy2Kcu&_nc_ohc=QLamqZ9CDGcQ7kNvgE7zN-5&_nc_zt=23&_nc_ht=scontent.fmnl17-6.fna&oh=03_Q7cD1QFzHFdnGRvjdQKIUgM7U3Ws1f1hsVOmBdVWGU4P0GjREw&oe=677EB756"
                    alt="" />
                </div>
              </div>
              <div class="donation-gcash">
                <div class="donation-gcash-title">
                  <h1>GCash Instruction</h1>
                </div>
                <div class="donation-gcash-instruction">
                  <div class="instruction">
                    <h3>Login in to GCash and tap Pay QR</h3>
                    <h3>Scan our QR code</h3>
                    <h3>Input the total amount and tap Next</h3>
                    <h3>Review all details then tap on Pay</h3>
                  </div>
                  <img
                    class="bpi-qr"
                    src="https://scontent.fmnl17-2.fna.fbcdn.net/v/t1.15752-9/462648968_975804401042881_4021586219592493605_n.png?_nc_cat=107&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFZKqpC_ai4Kw9rt4NRnM0okrf8JPXZYtqSt_wk9dli2k3bQK4DD_hxVyqSeWJmWVXb_nMY3_Q_q_izz37_N9pl&_nc_ohc=lyF33_JtVAgQ7kNvgEKE0vs&_nc_zt=23&_nc_ht=scontent.fmnl17-2.fna&oh=03_Q7cD1QGnnEPMTdkrrgcaot_AO6aRLoG_iFOOYaNK7ikNfwS_hQ&oe=677EB902"
                    alt="" />
                </div>
              </div>
            </div>
            <form id="donationForm" class="donation-form">
              <div class="personal-main-cont">
                <div class="personal-details">
                  <div class="left">
                    <h3>Enter your name</h3>
                    <input class="input-name" name="donor_name" placeholder="Name" type="text" required />
                  </div>
                  <div class="right">
                    <h3>Enter your number</h3>
                    <input
                      class="input-name"
                      name="phone"
                      placeholder="Number"
                      type="text" />
                  </div>
                </div>
                <h3>Enter your email</h3>
                <input class="input-name" name="email" placeholder="Email" type="email" required />
                <h3>Enter the Transaction number/Reference number</h3>
                <input
                  class="input-name"
                  name="reference_number"
                  placeholder="Reference number"
                  type="text" required />
                <h3>Payment Method</h3>
                <select class="input-name" name="payment_method" required>
                  <option value="">Select Payment Method</option>
                  <option value="gcash">GCash</option>
                  <option value="bpi">BPI</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="other">Other</option>
                </select>
                <h3>Message (Optional)</h3>
                <textarea class="input-name" name="message" placeholder="Leave a message..." rows="3"></textarea>
              </div>

              <div class="donation-payment-cont">
                <div class="donation-time">
                  <div class="one-time active" data-type="one_time">
                    <h1>One Time</h1>
                  </div>
                  <div class="monthly" data-type="monthly">
                    <h1>Monthly</h1>
                  </div>
                </div>
                <input type="hidden" name="donation_type" value="one_time" />

                <div class="donation-price">
                  <h3>Enter how much you donated</h3>
                  <div class="prices-row">
                    <a class="price" data-amount="100">₱100</a>
                    <a class="price" data-amount="250">₱250</a>
                    <a class="price" data-amount="500">₱500</a>
                    <a class="price" data-amount="1000">₱1000</a>
                    <input class="input-price" name="amount" placeholder="₱" type="number" min="20" required />
                  </div>
                  <h3>
                    ₱20 is the minimum online donation. All donations are tax
                    deductibles
                  </h3>
                  <div id="donation-message" class="donation-message"></div>
                </div>
                <div class="continue">
                  <button type="submit" class="continue-button">Submit Donation</button>
                  <button type="button" class="cancel-button" onclick="resetForm()">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="campaigns"></div>
      </div>
    </div>
  </div>

  <script>
    lazyload();

    const hamburger = document.querySelector(".Hamburger");
    const navMenu = document.querySelector(".header-right");

    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("active");
    });

    // Donation type selection
    const one_time = document.querySelector(".one-time");
    const monthly = document.querySelector(".monthly");
    const donationTypeInput = document.querySelector('input[name="donation_type"]');

    one_time.addEventListener("click", () => {
      if (monthly.classList.contains("active")) {
        one_time.classList.add("active");
        monthly.classList.remove("active");
        donationTypeInput.value = "one_time";
      }
    });

    monthly.addEventListener("click", () => {
      if (one_time.classList.contains("active")) {
        monthly.classList.add("active");
        one_time.classList.remove("active");
        donationTypeInput.value = "monthly";
      }
    });

    // Price selection
    const prices = document.querySelectorAll(".price");
    const amountInput = document.querySelector('input[name="amount"]');

    prices.forEach((price) => {
      price.addEventListener("click", () => {
        prices.forEach((p) => p.classList.remove("active"));
        price.classList.add("active");

        // Set the amount in the input field
        const amount = price.getAttribute('data-amount');
        if (amount) {
          amountInput.value = amount;
        }
      });
    });

    // Form submission
    const donationForm = document.getElementById('donationForm');
    const messageDiv = document.getElementById('donation-message');

    donationForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      // Show loading state
      const submitBtn = document.querySelector('.continue-button');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Processing...';
      submitBtn.disabled = true;
      donationForm.classList.add('loading');

      // Hide previous messages
      messageDiv.style.display = 'none';
      messageDiv.className = 'donation-message';

      try {
        const formData = new FormData(donationForm);

        const response = await fetch('process_donation.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (result.success) {
          messageDiv.className = 'donation-message success';
          messageDiv.textContent = result.message;
          messageDiv.style.display = 'block';

          // Reset form after successful submission
          setTimeout(() => {
            resetForm();
          }, 3000);
        } else {
          messageDiv.className = 'donation-message error';
          messageDiv.textContent = result.message;
          messageDiv.style.display = 'block';
        }
      } catch (error) {
        messageDiv.className = 'donation-message error';
        messageDiv.textContent = 'An error occurred while processing your donation. Please try again.';
        messageDiv.style.display = 'block';
      } finally {
        // Reset loading state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        donationForm.classList.remove('loading');
      }
    });

    // Reset form function
    function resetForm() {
      donationForm.reset();
      prices.forEach(p => p.classList.remove('active'));
      one_time.classList.add('active');
      monthly.classList.remove('active');
      donationTypeInput.value = 'one_time';
      messageDiv.style.display = 'none';
      messageDiv.className = 'donation-message';
    }
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
                    <a href="home#about-us" class="c-link">About Us</a>
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
</body>

</html>