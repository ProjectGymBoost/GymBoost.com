//   active page highlight
  const urlParams = new URLSearchParams(window.location.search);
  const currentPage = urlParams.get('page');

  const navLinks = document.querySelectorAll('.nav-link');

  navLinks.forEach(link => {
    const linkUrl = new URL(link.href);
    const linkPage = linkUrl.searchParams.get('page');

    if (linkPage === currentPage) {
      link.classList.add('active');
    }
  });

// open navbar
    function openNav() {
      document.getElementById("myNav").style.width = "100%";
    }
// close navbar
    function closeNav() {
      document.getElementById("myNav").style.width = "0%";
    }


    