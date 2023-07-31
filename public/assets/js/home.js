// Start NavBar : Change navbar background after scroll down by 600

var nav = document.querySelector(".nav-bar-component");
var addBg = document.querySelector(".navbar-toggler");
nav.style.background = "transparent";
window.addEventListener("scroll", function () {
  scrollPosition = window.scrollY;
  scrollPosition >= 600
    ? nav.classList.add("nav-active")
    : nav.classList.remove("nav-active");
});

// End NavBar
