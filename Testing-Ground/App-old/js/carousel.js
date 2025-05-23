document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".carousel-container");
  const carouselCont = document.querySelector(".carousel-items");

  const items = document.querySelector(".carousel-items");
  const itemHeight = document.querySelector(".carousel-item").offsetHeight;
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
      const isHighlightedFollow = hoveredItem.classList.contains("highlighted");

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
      const targetY = e.pageY + document.documentElement.clientHeight * 0.1;
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
      ((highlightedItemTop + highlightedItem.clientHeight / 2 - firstItemTop) /
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

  const observer = new IntersectionObserver(observerCallback, observerOptions);

  observer.observe(container);
});
const hamburger = document.querySelector(".Hamburger");
const navMenu = document.querySelector(".header-right");

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active");
  navMenu.classList.toggle("active");
});
