const tragets = document.querySelectorAll("img");
const lazyLoad = (traget) => {
  const io = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
      }
    });
  });
};
