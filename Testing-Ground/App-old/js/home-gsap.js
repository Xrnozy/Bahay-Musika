gsap.registerPlugin(ScrollTrigger);
ScrollTrigger.normalizeScroll(true);
const { innerHeight } = window;
const aboutUs = document.getElementById("about-us");
const imgSticky = document.querySelector(".img-sticky-container");
const imgItems = gsap.utils.toArray(".img-items");

gsap
  .timeline({
    scrollTrigger: {
      trigger: aboutUs,
      start: "top top",
      pin: true,
      scrub: 1,
      end: "+=" + aboutUs.offsetWidth * imgItems.length,
    },
  })
  .to(".guitar", {
    scale: 5,
    delay: 1,
    ease: "linear",
    duration: 3,
  })

  .to(
    ".img-content",
    {
      scale: 1.1,
      ease: "ease",
      duration: 6,
    },
    "<"
  )

  .to(
    ".guitar",
    {
      opacity: 0,
      delay: 1.5,
      duration: 4,
    },
    "<"
  )
  .to(".img-content", {
    xPercent: -100 * (imgItems.length - 1),
    ease: "sine.out",
    snap: 1 / (imgItems.length - 1),
    duration: 10,
  })
  .to(
    ".about-us-text",
    {
      opacity: 1,
      ease: "linear",
      duration: 4,
      delay: 2,
    },

    "<"
  )
  .to(
    ".pCont",
    {
      left: "0px",
      ease: "ease",
      duration: 3,
      opacity: 1,
      delay: 1,
    },

    "<"
  );
