<title>Bahay Musika - Events</title>
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


<div id="body-main-cont">
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const container = document.querySelector(".carousel-container");
      const carouselCont = document.querySelector(".carousel-items");

      if (!container || !carouselCont) {
        console.error("Carousel container or items not found.");
        return;
      }

      const items = document.querySelector(".carousel-items");
      const carouselItems = document.querySelectorAll(".carousel-item");

      if (!items || carouselItems.length === 0) {
        console.error("Carousel items not found.");
        return;
      }

      let currentIndex = 0;
      let isScrolling = false;
      let autoScrollInterval;

      const updateCarousel = () => {
        items.style.transform = `translateX(-${currentIndex * 100}%)`;
        carouselItems.forEach((item, index) => {
          item.classList.toggle("active", index === currentIndex);
        });
      };

      const nextItem = () => {
        currentIndex = (currentIndex + 1) % carouselItems.length;
        updateCarousel();
      };

      const prevItem = () => {
        currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
        updateCarousel();
      };

      const handleScroll = (event) => {
        if (isScrolling) return;
        isScrolling = true;
        event.deltaY > 0 ? nextItem() : prevItem();
        setTimeout(() => (isScrolling = false), 500);
      };

      const startAutoScroll = () => {
        autoScrollInterval = setInterval(nextItem, 5000);
      };

      const stopAutoScroll = () => {
        clearInterval(autoScrollInterval);
      };

      container.addEventListener("wheel", handleScroll);
      container.addEventListener("mouseenter", stopAutoScroll);
      container.addEventListener("mouseleave", startAutoScroll);

      updateCarousel();
      startAutoScroll();
    });
    const hamburger = document.querySelector(".Hamburger");
    const navMenu = document.querySelector(".header-right");

    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  </script>
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
        <div class="upcoming-events">
          <h1>December 2024</h1>
          <p class="upcominig-title">Event Calendar</p>
          <ul>
            <li>
              <a class="event-link" href="https://example.com"></a>
              <time datetime="2022-02-01">1</time>
              <h1 class="events-title">Rustan's Shangri-La 5:00pm</h1>
            </li>
            <li><time datetime="2022-02-02">2</time></li>
            <li><time datetime="2022-02-03">3</time></li>
            <li>
              <a class="event-link" href="https://example.com"></a>
              <time datetime="2022-02-04">4</time>
              <h1 class="events-title">Rustan's Alabang 3:00pm</h1>
            </li>
            <li><time datetime="2022-02-05">5</time></li>
            <li><time datetime="2022-02-06">6</time></li>
            <li><time datetime="2022-02-07">7</time></li>
            <li><time datetime="2022-02-08">8</time></li>
            <li><time datetime="2022-02-09">9</time></li>
            <li class="today"><time datetime="2022-02-10">10</time></li>
            <li><time datetime="2022-02-11">11</time></li>
            <li><time datetime="2022-02-12">12</time></li>
            <li><time datetime="2022-02-13">13</time></li>
            <li><time datetime="2022-02-14">14</time></li>
            <li><time datetime="2022-02-15">15</time></li>
            <li>
              <time datetime="2022-02-16">16</time>
            </li>
            <li><time datetime="2022-02-17">17</time></li>
            <li><time datetime="2022-02-18">18</time></li>
            <li>
              <time datetime="2022-02-19">19</time>
            </li>
            <li><time datetime="2022-02-20">20</time></li>
            <li><time datetime="2022-02-21">21</time></li>
            <li>
              <a class="event-link" href="https://example.com"></a>
              <time datetime="2022-02-22">22</time>
              <h1 class="events-title">Rustan's Makati 4:00pm</h1>
            </li>
            <li><time datetime="2022-02-23">23</time></li>
            <li><time datetime="2022-02-24">24</time></li>
            <li><time datetime="2022-02-25">25</time></li>
            <li><time datetime="2022-02-26">26</time></li>
            <li>
              <a class="event-link" href="https://example.com"></a>
              <time datetime="2022-02-27">27</time>
              <h1 class="events-title">Rustan's Shangri-La 5:00pm</h1>
            </li>
            <li><time datetime="2022-02-28">28</time></li>
            <li>
              <a class="event-link" href="https://example.com"></a>
              <time datetime="2022-02-28">29</time>
              <h1 class="events-title">Rustan's Makati 4:00pm</h1>
            </li>
          </ul>
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
  <script>
    const events = [{
        label: "ICYMI",
        class: "icymi",
        date: "October 19 2024",
        title: "ICYMI: <i>The capabilities building program and values formation program 'Film Viewing'</i>",
        location: "Bahay Musika Building",
        detail: "An annual film viewing for the beneficiaries of the organization...",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      },
      {
        label: "Under the Baton",
        class: "baton",
        date: "August 31 2024",
        title: "Under the baton: <i>The Anthony Villanueva music festival</i>",
        location: "Tanghalang yaman lahi, Emilio Aguinaldo College",
        detail: "Minstrels of hope headed by their musical director...",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      },
      {
        label: "Benildean Operation Sagip",
        class: "sagip",
        date: "July 27 2024",
        title: "Benildean operation sagip: <i>Bagyong Carina</i>",
        location: "Benilde Center for Social Action",
        detail: "Donations through relief packs for the victims of bagyong Carina...",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      },
      {
        label: "Back to School Program 2024",
        class: "school",
        date: "July 21 2024",
        title: "Back to school program 2024 <i>“Bayanihan sa bahay musika...”</i>",
        location: "Silahis ng Karunungan Special School",
        detail: "Donation of school supplies and essentials for the disabled children...",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      },
      {
        label: "Prayer and Contemplation",
        class: "pray",
        date: "March 17 2024",
        title: "Prayer and Contemplation",
        location: "Barangay 825 Zone 89 Saint Teri Chapel",
        detail: "Helping beneficiaries engage their hearts and mind to God's presence.",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      },
      {
        label: "Values Formation",
        class: "values",
        date: "November 27 2023",
        title: "Values Formation",
        location: "Barangay 828 Zone 89 Paco Manila",
        detail: "Promoting a child's well-being and access to nutrition and safety.",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      },
      {
        label: "HIV Awareness",
        class: "hiv",
        date: "June 2 2024",
        title: "Reproductive Health and HIV Awareness",
        location: "Merced St. Paco Manila",
        detail: "Educating people about HIV prevention and positive sexual attitudes.",
        images: ["img/11.jpg", "img/12.jpg", "img/12.jpg", "img/12.jpg"]
      }
    ];

    function renderEvent(index) {
      const event = events[index];
      const eventSlider = document.querySelector(".event-slider");

      eventSlider.innerHTML = `
      <div class="container-desc-per ${event.class}">
        <div class="event-description-item slick-slide">
          <div class="time">
            <span class="date-label date-label-${event.class}">${event.date}</span>
            <p class="event-title event-title-${event.class}">${event.title}</p>
            <div class="date-cont">
              <span class="location-label location-label-${event.class}">
                <p>${event.location}</p>
                <div class="rectangle"></div>
              </span>
            </div>
            <p class="event-detail event-detail-${event.class}">${event.detail}</p>
            <div class="event-img event-img-${event.class}">
              ${event.images.map((src, i) => `<img src="${src}" alt="Image ${i + 1}" class="img img-${event.class} img-${i + 1}">`).join("")}
            </div>
          </div>
        </div>
      </div>
    `;
    }

    document.addEventListener("DOMContentLoaded", () => {
      const carouselContainer = document.querySelector(".carousel-items");

      // Dynamically build carousel items
      events.forEach((event, index) => {
        const item = document.createElement("div");
        item.classList.add("carousel-item");
        if (index === 0) item.classList.add("active"); // initial active item
        item.textContent = event.label;

        item.addEventListener("click", () => {
          renderEvent(index);
          document.querySelectorAll(".carousel-item").forEach(i => i.classList.remove("active"));
          item.classList.add("active");
        });

        carouselContainer.appendChild(item);
      });

      // Initial render
      renderEvent(0);
    });
  </script>


</div>