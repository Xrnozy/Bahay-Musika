document.addEventListener("DOMContentLoaded", () => {
  const resources = document.querySelectorAll("img, script, link, iframe");
  const totalResources = resources.length;
  let loadedResources = 0;

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

  // Messages to display during loading
  const messages = [
    "Initializing",
    "Loading assets",
    "Preparing interface",
    "Almost ready",
    "Finalizing",
  ];
  function updateProgress() {
    loadedResources++;
    console.log(
      `updateProgress() CALLED! Loaded: ${loadedResources}, Total: ${totalResources}`
    );

    let percentage =
      totalResources > 0
        ? Math.round((loadedResources / totalResources) * 100)
        : 0;

    if (percentage >= 100) {
      console.log("All resources loaded!");
    }

    return percentage;
  }

  resources.forEach((resource) => {
    if (resource.complete) {
      setTimeout(updateProgress, 0); // Ensures preloaded resources count once
    } else {
      resource.addEventListener("load", updateProgress, { once: true });
      resource.addEventListener("error", updateProgress, { once: true });
    }
  });

  // Create particles
  for (let i = 0; i < 30; i++) {
    createParticle();
  }

  function createParticle() {
    const particle = document.createElement("div");
    particle.className = "particle";

    // Random position
    const x = Math.random() * 100;
    const y = Math.random() * 100;

    particle.style.left = `${x}%`;
    particle.style.top = `${y}%`;

    particlesContainer.appendChild(particle);
  }

  // Initialize GSAP timeline
  const tl = gsap.timeline();

  // Show counter
  tl.to(counter, {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: "power2.out",
  })

    // Show message
    .to(
      message,
      {
        opacity: 0.7,
        duration: 1,
        ease: "power2.out",
      },
      "<"
    )

    // Animate horizontal lines
    .to(horizontalLines, {
      scaleX: 1,
      duration: 2,
      stagger: 0.2,
      ease: "power1.inOut",
      onComplete: function () {
        animateParticles();
      },
    })

    // Animate vertical lines
    .to(
      verticalLines,
      {
        scaleY: 1,
        duration: 2,
        stagger: 0.2,
        ease: "power1.inOut",
      },
      "-=1.8"
    )

    // Animate dots
    .to(dots, {
      opacity: 1,
      duration: 0.3,
      stagger: 0.1,
      ease: "power1.out",
    })

    // Animate loading progress
    .to(
      progressBar,
      {
        width: "100%",
        duration: 8,
        ease: "power1.inOut",
        onUpdate: function () {
          let percentage = updateProgress(); // Call once
          counter.textContent = percentage;
          updateMessage(percentage);
          updateColors(percentage);
        },
      },
      "-=4"
    )

    // Transition to main content
    .to(preloader, {
      y: "-100vh",
      duration: 1.2,
      ease: "power3.inOut",
      delay: 0.8,
    })
    .set(
      content,
      {
        visibility: "visible",
      },
      "<"
    )
    .to(
      content,
      {
        opacity: 1,
        duration: 1,
        ease: "power2.out",
      },
      "<0.3"
    )
    .to(
      preloader,
      {
        opacity: 0,
        duration: 1,
        ease: "power2.out",
        onComplete: () => {
          preloader.style.display = "none"; // Hide after fade-out
        },
      },
      "<0.3"
    )

    .to(
      [title, paragraph],
      {
        opacity: 1,
        y: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power2.out",
      },
      "<0.2"
    )
    .set(preloader, {
      display: "none",
    });

  // Function to animate particles
  function animateParticles() {
    const particles = document.querySelectorAll(".particle");

    particles.forEach((particle) => {
      // Random movement
      const xMove = (Math.random() - 0.5) * 50;
      const yMove = (Math.random() - 0.5) * 50;
      const delay = Math.random() * 5;

      gsap.to(particle, {
        opacity: 0.7,
        duration: 0.5,
        delay: delay,
      });

      gsap.to(particle, {
        x: xMove,
        y: yMove,
        duration: 10 + Math.random() * 10,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
        delay: delay,
      });
    });
  }

  // Function to update message
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
          gsap.to(message, {
            opacity: 0.7,
            duration: 0.5,
          });
        },
      });
    }
  }

  // Function to update colors based on progress
  function updateColors(progress) {}
});
