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
  <script src="lib/tesseract.min.js"></script>
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
    }

    .cancel-button {
      background-color: #f44336;
      color: #ffffff;
    }

    .form-step {
      display: none;
      animation: fadeIn 0.5s ease-in-out;
    }

    .form-step.active-step {
      display: block;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .next-step {
      background-color: #4caf50;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .next-step:hover {
      background-color: #45a049;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #555;
      border-radius: 4px;
      background-color: #1f1f1f;
      color: white;
    }

    .method-card {
      display: flex;
      align-items: center;
      width: auto;
      gap: 10px;
      margin-bottom: 15px;
      background-color: #2a2a2a;
      padding: 12px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .method-card:hover {
      background-color: #333;
    }

    .amount-options {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .amount-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
    }

    .amount-option {
      background-color: #2a2a2a;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-align: center;
    }

    .amount-option:hover {
      background-color: #333;
    }

    .custom-amount {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .step-actions {
      display: flex;
      align-items: end;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
      justify-content: flex-end;
    }

    .back-step {
      background-color: #888;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .back-step:hover {
      background-color: #555;
    }

    .step-actions-donations {
      height: 100%;
      display: flex;
      flex-direction: row;
      gap: 10px;
      align-items: center;
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
                  When you give, you’re not just helping someone in
                  need—you’re creating a ripple of hope, kindness, and
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
            <form class="payment-container" action="donation_submit.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="donation_type" id="donation_type" value="one_time">
              <div class="payment-header">
                <h2 class="payment-title">Support Bahay Musika</h2>
                <div class="donation-type">
                  <button type="button" class="type-option active" data-type="one_time">One-Time Donation</button>
                  <button type="button" class="type-option" data-type="monthly">Monthly Support</button>
                </div>
              </div>

              <div class="payment-body">
                <div class="form-step active-step">
                  <h3 class="section-title">Billing Information</h3>
                  <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-input" name="donor_name" required>
                  </div>
                  <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-input" name="donor_email" required>
                  </div>
                  <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-input" name="phone" required>
                  </div>
                  <div class="step-actions">
                    <button type="button" class="next-step">Next</button>
                  </div>
                </div>

                <div class="form-step">
                  <h3 class="section-title">Payment Method</h3>
                  <div class="payment-methods">
                    <div class="method-option">
                      <input type="radio" name="payment_method" id="gcash" value="gcash" required>
                      <label for="gcash" class="method-card">
                        <img src="icons/gcash.png" alt="GCash">
                        <span>GCash</span>
                      </label>
                    </div>
                    <div class="method-option">
                      <input type="radio" name="payment_method" id="paypal" value="paypal">
                      <label for="paypal" class="method-card">
                        <img src="icons/paypal.png" alt="PayPal">
                        <span>PayPal</span>
                      </label>
                    </div>
                  </div>
                  <div class="step-actions">
                    <button type="button" class="back-step">Back</button>
                    <button type="button" class="next-step">Next</button>
                  </div>
                </div>

                <div class="form-step">
                  <h3 class="section-title">Donation Amount</h3>
                  <div class="amount-options">
                    <div class="amount-grid">
                      <button type="button" class="amount-option">₱100</button>
                      <button type="button" class="amount-option">₱500</button>
                      <button type="button" class="amount-option">₱1000</button>
                      <button type="button" class="amount-option">₱5000</button>
                    </div>
                    <div class="custom-amount">
                      <input type="number" class="form-input" name="amount" placeholder="Enter Custom Amount" min="1" required>
                    </div>
                  </div>
                  <div class="step-actions">
                    <button type="button" class="back-step">Back</button>
                    <button type="button" class="next-step">Next</button>
                  </div>
                </div>

                <div class="form-step">
                  <h3 class="section-title">Transaction ID</h3>
                  <div class="form-group">
                    <label>Enter GCash/PayPal Transaction ID</label>
                    <input type="text" class="form-input" name="transaction_id" required>
                  </div>
                  <div class="form-group">
                    <label>Upload Screenshot/Proof of Transaction</label>
                    <input type="file" class="form-input" name="transaction_proof" id="transaction_proof" accept="image/*" required>
                    <button type="button" id="validate-ocr" class="next-step" style="margin-top:10px;background:#ffd600;color:#181818;">Validate Transaction ID</button>
                    <div id="ocr-validation-message" style="margin-top:10px;color:#ffd600;"></div>
                  </div>
                  <div class="step-actions">
                    <div class="step-actions-donations">
                      <button type="button" class="back-step back-step-donation">Back</button>
                      <button type="submit" class="submit-button">Complete Donation</button>
                    </div>

                  </div>
                </div>
              </div>
              <script>
                const typeOption = document.querySelectorAll('.type-option');
                const donationTypeInput = document.getElementById('donation_type');
                typeOption.forEach(option => {
                  option.addEventListener('click', () => {
                    typeOption.forEach(opt => opt.classList.remove('active'));
                    option.classList.add('active');
                    // Set hidden input value
                    donationTypeInput.value = option.getAttribute('data-type');
                  });
                });


                const formSteps = document.querySelectorAll('.form-step');
                const nextSteps = document.querySelectorAll('.next-step');
                const backSteps = document.querySelectorAll('.back-step');
                let currentStep = 0;
                nextSteps.forEach(btn => {
                  btn.addEventListener('click', () => {
                    // Don't show warning for the Validate Transaction ID button
                    if (btn.id === 'validate-ocr') return;
                    // Find the current step
                    const currentFormStep = formSteps[currentStep];
                    // Get all required inputs in the current step
                    const requiredInputs = currentFormStep.querySelectorAll('input[required], select[required], textarea[required]');
                    let allFilled = true;
                    requiredInputs.forEach(input => {
                      if (!input.value || (input.type === 'radio' && !currentFormStep.querySelector('input[type="radio"]:checked'))) {
                        allFilled = false;
                      }
                    });
                    // Show a warning if not all required fields are filled
                    let warning = currentFormStep.querySelector('.step-warning');
                    if (!allFilled) {
                      if (!warning) {
                        warning = document.createElement('div');
                        warning.className = 'step-warning';
                        warning.style.color = '#ffd600';
                        warning.style.marginTop = '0px';
                        warning.style.marginBottom = '10px';
                        warning.textContent = 'Please complete all required fields before proceeding.';
                        // Insert warning above the first .step-actions button
                        const stepActions = currentFormStep.querySelector('.step-actions');
                        if (stepActions) {
                          currentFormStep.insertBefore(warning, stepActions);
                        } else {
                          currentFormStep.appendChild(warning);
                        }
                      }
                      warning.style.display = 'block';
                      return;
                    } else if (warning) {
                      warning.style.display = 'none';
                    }
                    if (currentStep < formSteps.length - 1) {
                      formSteps[currentStep].classList.remove('active-step');
                      currentStep++;
                      formSteps[currentStep].classList.add('active-step');
                    }
                  });
                });
                backSteps.forEach(btn => {
                  btn.addEventListener('click', () => {
                    if (currentStep > 0) {
                      formSteps[currentStep].classList.remove('active-step');
                      currentStep--;
                      formSteps[currentStep].classList.add('active-step');
                    }
                  });
                });

                // OCR Transaction ID Validation
                let ocrValidated = false;
                const validateOcrBtn = document.getElementById('validate-ocr');
                const transactionProofInput = document.getElementById('transaction_proof');
                const transactionIdInput = document.querySelector('input[name="transaction_id"]');
                const ocrValidationMessage = document.getElementById('ocr-validation-message');

                validateOcrBtn.addEventListener('click', async () => {
                  ocrValidationMessage.textContent = 'Processing image, please wait...';
                  ocrValidationMessage.style.color = '#ffd600';
                  const file = transactionProofInput.files[0];
                  if (!file) {
                    ocrValidationMessage.textContent = 'Please upload a transaction proof image.';
                    ocrValidationMessage.style.color = '#ffd600';
                    ocrValidated = false;
                    return;
                  }
                  const reader = new FileReader();
                  reader.onload = async function(e) {
                    try {
                      const {
                        data: {
                          text
                        }
                      } = await Tesseract.recognize(e.target.result, 'eng', {
                        logger: m => console.log(m)
                      });
                      const enteredId = transactionIdInput.value.trim();
                      if (!enteredId) {
                        ocrValidationMessage.textContent = 'Please enter your Transaction ID first.';
                        ocrValidationMessage.style.color = '#f44336';
                        ocrValidated = false;
                        return;
                      }
                      const cleanText = text.replace(/\s/g, ' ').toLowerCase();
                      const cleanEnteredId = enteredId.replace(/\s/g, '').toLowerCase();
                      let found = false;
                      const words = cleanText.split(' ');
                      for (let word of words) {
                        if (word.length === cleanEnteredId.length && word === cleanEnteredId) {
                          found = true;
                          break;
                        }
                      }
                      if (found) {
                        ocrValidationMessage.textContent = '✅ Transaction ID validated successfully!';
                        ocrValidationMessage.style.color = '#4caf50';
                        ocrValidated = true;
                      } else {
                        ocrValidationMessage.textContent = '❌ Transaction ID not found in the uploaded image. Please check and try again.';
                        ocrValidationMessage.style.color = '#f44336';
                        ocrValidated = false;
                      }
                    } catch (err) {
                      ocrValidationMessage.textContent = 'Error processing image. Please try again or use a clearer image.';
                      ocrValidationMessage.style.color = '#f44336';
                      ocrValidated = false;
                    }
                  };
                  reader.readAsDataURL(file);
                });

                // Prevent form submission if OCR is not validated
                const donationForm = document.querySelector('.payment-container');
                donationForm.addEventListener('submit', function(e) {
                  // Only require OCR validation on the last step (transaction proof)
                  const lastStep = formSteps[formSteps.length - 1];
                  if (lastStep.classList.contains('active-step')) {
                    if (!ocrValidated) {
                      e.preventDefault();
                      ocrValidationMessage.textContent = 'Please validate your Transaction ID before submitting.';
                      ocrValidationMessage.style.color = '#f44336';
                    }
                  }
                });

                // Payment Amount Selection Logic
                const amountOptions = document.querySelectorAll('.amount-option');
                const customAmountInput = document.querySelector('input[name="amount"]');

                amountOptions.forEach(option => {
                  option.addEventListener('click', () => {
                    // Remove active from all
                    amountOptions.forEach(opt => opt.classList.remove('active'));
                    // Set active on clicked
                    option.classList.add('active');
                    // Set custom input value but do NOT disable it
                    customAmountInput.value = option.textContent.replace(/[^\d]/g, '');
                    customAmountInput.classList.remove('disabled');
                  });
                });
                customAmountInput.addEventListener('input', () => {
                  // Remove active from all preset buttons if custom is being typed
                  if (customAmountInput.value) {
                    amountOptions.forEach(opt => opt.classList.remove('active'));
                    customAmountInput.classList.remove('disabled');
                  }
                });
                customAmountInput.addEventListener('focus', () => {
                  amountOptions.forEach(opt => opt.classList.remove('active'));
                  customAmountInput.classList.remove('disabled');
                });
              </script>
              <div class="payment-footer">

                <p class="security-note">
                  <i class="fas fa-lock"></i>
                  Your donation is secure and encrypted
                </p>
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
    const one_time = document.querySelector(".one-time");
    const monthly = document.querySelector(".monthly");
    one_time.addEventListener("click", () => {
      if (monthly.classList.contains("active")) {
        one_time.classList.toggle("active");
        monthly.classList.toggle("active");
      }
    });
    monthly.addEventListener("click", () => {
      if (one_time.classList.contains("active")) {
        one_time.classList.toggle("active");
        monthly.classList.toggle("active");
      }
    });
    const prices = document.querySelectorAll(".price");

    prices.forEach((price) => {
      price.addEventListener("click", () => {
        prices.forEach((p) => p.classList.remove("active"));

        price.classList.add("active");
      });
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