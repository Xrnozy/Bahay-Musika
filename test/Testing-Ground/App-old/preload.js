document.addEventListener("DOMContentLoaded", () => {
  const resources = document.querySelectorAll(
    "img, script, link[rel='stylesheet'], iframe"
  );
  const totalResources = resources.length;
  let loadedResources = 0;
  let startTime = performance.now();

  // Elements
  const preloader = document.querySelector(".preloader");
  const counter = document.querySelector(".counter");
  const progressBar = document.querySelector(".progress-bar-fill");
  const content = document.querySelector(".body-cont");
  const title = document.querySelector(".content h1");
  const paragraph = document.querySelector(".content p");
  const horizontalLines = document.querySelectorAll(".horizontal-line");
  const verticalLines = document.querySelectorAll(".vertical-line");
  const dots = document.querySelectorAll(".dot");
  const message = document.querySelector(".message");
  const particlesContainer = document.getElementById("particles-container");

  const messages = [
    "Initializing",
    "Loading assets",
    "Preparing interface",
    "Almost ready",
    "Finalizing",
  ];
  function updateProgress() {
    loadedResources++;
    let percentage =
      totalResources > 0
        ? Math.round((loadedResources / totalResources) * 100)
        : 0;
    return percentage;
  }

  resources.forEach((resource) => {
    if (resource.complete) {
      setTimeout(updateProgress, 0);
    } else {
      resource.addEventListener("load", updateProgress, { once: true });
      resource.addEventListener("error", updateProgress, { once: true });
    }
  });

  let loadDuration = Math.max(3, (performance.now() - startTime) / 1000);

  for (let i = 0; i < 30; i++) {
    createParticle();
  }

  function createParticle() {
    const particle = document.createElement("div");
    particle.className = "particle";
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;
    particlesContainer.appendChild(particle);
  }

  const tl = gsap.timeline();

  tl.to(counter, { opacity: 1, y: 0, duration: 0.5 })
    .to(message, { opacity: 0.7, duration: 0.5 }, "<")
    .to(horizontalLines, {
      scaleX: 1,
      duration: loadDuration / 4,
      stagger: 0.2,
      ease: "power1.inOut",
    })
    .to(
      verticalLines,
      {
        scaleY: 1,
        duration: loadDuration / 4,
        stagger: 0.2,
        ease: "power1.inOut",
      },
      "-=1.8"
    )
    .to(dots, { opacity: 1, duration: 0.3, stagger: 0.1, ease: "power1.out" })
    .to(
      progressBar,
      {
        width: "100%",
        duration: loadDuration / 2,
        ease: "power1.inOut",
        onUpdate: function () {
          let percentage = updateProgress();
          counter.textContent = percentage;
          updateMessage(percentage);
        },
      },
      "-=2"
    )
    .to(preloader, {
      y: "-100vh",
      duration: 1.2,
      ease: "power3.inOut",
      delay: 0.8,
    })
    .set(content, { visibility: "visible" }, "<")
    .to(content, { opacity: 1, duration: 1, ease: "power2.out" }, "<0.3")
    .to(
      preloader,
      {
        opacity: 0,
        duration: 1,
        ease: "power2.out",
        onComplete: () => (preloader.style.display = "none"),
      },
      "<0.3"
    )
    .to(
      [title, paragraph],
      { opacity: 1, y: 0, duration: 1, stagger: 0.2, ease: "power2.out" },
      "<0.2"
    );

  function updateMessage(progress) {
    const messageIndex = Math.min(
      Math.floor(progress / 25),
      messages.length - 1
    );
    const currentMessage = messages[messageIndex];
    if (message.textContent !== currentMessage) {
      gsap.to(message, {
        opacity: 0,
        duration: 0.5,
        onComplete: function () {
          message.textContent = currentMessage;
          gsap.to(message, { opacity: 0.7, duration: 0.5 });
        },
      });
    }
  }
});
