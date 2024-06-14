
  // Function to hide navbar content when mouse leaves navbar or when clicked outside
  document.addEventListener('DOMContentLoaded', function () {
    var navbar = document.querySelector('.navbar-collapse');

    // Function to hide navbar content
    function hideNavbarContent() {
      navbar.classList.remove('show');
    }

    // Hide navbar content when mouse leaves navbar
    navbar.addEventListener('mouseleave', function () {
      hideNavbarContent();
    });

    // Hide navbar content when clicked outside navbar
    document.addEventListener('click', function (event) {
      var target = event.target;
      if (!navbar.contains(target)) {
        hideNavbarContent();
      }
    });
  });
