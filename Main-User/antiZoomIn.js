window.addEventListener(
  "wheel",
  function (e) {
    if (e.ctrlKey) {
      e.preventDefault();
      return false;
    }
  },
  { passive: false }
);

window.addEventListener("keydown", function (e) {
  if (
    e.ctrlKey &&
    (e.key === "+" || e.key === "-" || e.key === "=" || e.key === "0")
  ) {
    e.preventDefault();
  }
});
