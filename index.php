<?php
session_start();

if (!empty($_SESSION['userID'])) {
  if (!empty($_SESSION['lastVisited'])) {
    header("Location: " . $_SESSION['lastVisited']);
    exit();
  }

  // Fallback 
  if ($_SESSION['role'] === 'admin') {
    header("Location: /GymBoost.com/admin/index.php");
  } else {
    header("Location: /GymBoost.com/user/index.php?page=dashboard");
  }
  exit();
}



$page = "home";

if (isset($_GET['page'])) {
  $page = $_GET['page'];
  switch ($page) {
    case "home":
      $page = "home";
      break;
    case "faqs":
      $page = "faqs";
      break;
    case "membership-plans":
      $page = "membership-plans";
      break;
    default:
      header("Location: ?page=home");
      break;
  }
} else {
  header("Location: ?page=home");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GymBoost</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="icon" type="image/png" href="assets/img/logo/officialLogo.png">
  <link href="assets/css/styles.css" rel="stylesheet" />
  <link href="assets/css/web.css" rel="stylesheet" />
</head>

<body>

  <!-- Navbar -->
  <div class="container-fluid px-0 fixed-top">
    <nav class="navbar navbar-expand-lg px-3 custom-navbar">

      <!-- Logo -->
      <a class="navbar-brand" href="?page=home">
        <img src="./assets/img/logo/officialLogo.png" width="40" height="40" alt="Logo">
      </a>

      <!-- Navbar Toggler (for mobile view) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navigation Links -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav text-start" style="font-weight:bold;">
          <li class="nav-item py-1 mx-2">
            <a class="nav-link px-4 py-1 <?php if ($page == 'home')
                                            echo 'active'; ?>" href="?page=home">HOME</a>
          </li>
          <li class="nav-item py-1 mx-2">
            <a class="nav-link px-4 py-1 <?php if ($page == 'membership-plans')
                                            echo 'active'; ?>" href="?page=membership-plans">MEMBERSHIP PLANS</a>
          </li>
          <li class="nav-item py-1 mx-2">
            <a class="nav-link px-4 py-1 <?php if ($page == 'faqs')
                                            echo 'active'; ?>" href="?page=faqs">FAQs</a>
          </li>
          <li class="nav-item d-lg-none py-1 mx-2">
            <a class="btn btn-login mt-2" href="login.php">LOGIN</a>
          </li>
        </ul>
      </div>

      <!-- Login Button -->
      <div class="d-none d-lg-flex align-items-center ms-auto">
        <a class="btn btn-login ms-3" href="login.php">LOGIN</a>
      </div>

    </nav>
  </div>

  <!-- Pages -->
  <?php include("web/" . $page . ".php"); ?>

  <!-- Footer -->
  <footer class="footer py-5 text-white">
    <div class="container">
      <div class="row align-items-center mb-2">
        <div class="col-12 col-md-3 text-center text-md-start">
          <img src="assets/img/logo/officialLogo.png" class="logo" height="40">
        </div>
      </div>

      <hr class="text-white my-4">

      <div class="row mb-3 text-center text-md-start">
        <div class="col-12 col-md-4 mb-1">
          <ul class="list-unstyled mb-1">
            <li class="subheading"><a href="" class="text-white text-decoration-none text-uppercase">GYMBOOST</a></li>
          </ul>
          <ul class="list-unstyled">
            <li><a href="?page=home#about" class="text-white text-decoration-none">About Us</a></li>
            <li><a href="?page=home#coaches" class="text-white text-decoration-none">Coaches</a></li>
            <li><a href="?page=membership-plans" class="text-white text-decoration-none">Membership</a></li>
            <li><a href="?page=membership-plans#plans" class="text-white text-decoration-none">Plans</a></li>
            <li><a href="?page=faqs" class="text-white text-decoration-none">FAQs</a></li>
          </ul>
        </div>

        <div class="col-12 col-md-4 mb-1">
          <ul class="list-unstyled mb-1">
            <li class="subheading"><a href="" class="text-white text-decoration-none text-uppercase">CONTACT US</a></li>
          </ul>

          <ul class="list-unstyled">
            <li class="me-3 mb-1">
              <a href="https://www.facebook.com/hardmusclebodyfitnessgym" class="text-white" target="_blank">
                <i class="bi bi-facebook me-2"></i>Hard Body Fitness Gym
              </a>
            </li>
            <li class="me-3 mb-1">
              <a href="https://mail.google.com/mail/?view=cm&fs=1&to=hardbodyfitnessgym13@gmail.com" class="text-white" target="_blank">
                <i class="bi bi-envelope-fill me-2"></i>hardbodyfitnessgym13@gmail.com
              </a>
            </li>

            <ul class="list-unstyled">
              <li>
                <i class="bi bi-telephone-fill mb-1 me-2"></i>
                <a href="tel:+639279904177" class="text-white">
                  +63 927 990 4177
                </a>
              </li>
            </ul>
          </ul>

        </div>

        <div class="col-12 col-md-4 text-center text-md-start">
          <ul class="list-unstyled mb-1">
            <li class="subheading "><a href="" class="text-white text-uppercase">ADDRESS</a></li>
          </ul>

          <ul class="list-unstyled">
            <li>
              <i class="bi bi-building-fill me-2"></i>
              <a href="https://www.google.com/maps?q=Purok+1,+Maharlika+Highway,+Brgy.+San+Rafael,+Sto.+Tomas+City,+Batangas"
                target="_blank"
                class="text-white">
                Purok 3, Maharlika Highway, Brgy. San Rafael, Sto. Tomas City, Batangas
              </a>
            </li>
          </ul>

        </div>

      </div>
      <hr class="text-white my-4">
      <div class="row align-items-center">
        <div class="col-12 text-center text-md-start mb-3 mb-md-0">
          <p class="mb-0">&copy; 2026 GymBoost. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <script>
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
      link.addEventListener('click', () => {
        document.querySelectorAll('.navbar-nav .nav-link').forEach(el => el.classList.remove('active'));
        link.classList.add('active');
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>