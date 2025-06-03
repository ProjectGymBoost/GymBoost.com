<?php
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="assets/img/logo/officialLogo.png">
  <link href="assets/css/styles.css" rel="stylesheet" />
  <link href="assets/css/web.css" rel="stylesheet" />
</head>
<style>
  .bg-img {
    background-image: url('assets/img/gym-img/gymbg1.png');
    background-size: cover;
    background-position: center;
    height: 100vh;
  }

  .card-animation {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card-animation:hover {
    transform: scale(1.02) rotate(1deg); 
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
  }
</style>

<body>
  <!-- Navigation Bar -->
  <nav class="navbar sticky-top position-absolute w-100 z-3">
    <div class="container-fluid d-flex align-items-center justify-content-between">
      <a href="?page=home" class="d-flex align-items-center">
        <img src="assets/img/logo/officialLogo.png" class="logo"/>
      </a>
      <div class="d-none d-lg-flex justify-content-center flex-grow-1">
        <a class="nav-link mx-2 px-3" href="?page=home">HOME</a>
        <a class="nav-link mx-2 px-3" href="?page=membership-plans">MEMBERSHIP PLANS</a>
        <a class="nav-link mx-2 px-3" href="?page=faqs">FAQs</a>
      </div>
      <div class="d-none d-lg-block">
        <a href="login.php">
          <div class="btn px-3 me-2 py-0">Login</div>
        </a>
      </div>
      <span class="d-block d-lg-none me-2" style="font-size:18px;cursor:pointer" onclick="openNav()">&#9776;</span>
    </div>
  </nav>

  <!-- Overlay nav -->
  <div id="myNav" class="overlay">
    <div class="d-flex justify-content-between align-items-center p-3 mt-2">
      <a href="?page=home">
        <img src="assets/img/logo/officialLogo.png" style="height: 50px;">
      </a>
      <a href="javascript:void(0)" class="closebtn fs-1 text-decoration-none" onclick="closeNav()">&times;</a>
    </div>

    <div class="overlay-content">
      <a class="nav-link mx-1" href="?page=home">Home</a>
      <a class="nav-link mx-1" href="?page=membership-plans">Membership Plans</a>
      <a class="nav-link mx-1" href="?page=faqs">FAQs</a>
      <a href="login.php" class="p-0">
        <div class="btn px-4 mt-5 mx-1 end-1 rounded-5">Login</div>
      </a>
    </div>
  </div>

  <!-- Pages -->
  <?php include("web/" . $page . ".php"); ?>

  <!-- Footer -->
  <footer class="footer mt-5 py-5 text-white">
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
            <li class="subheading"><a href="" class="text-white text-decoration-none">Join Us</a></li>
          </ul>
          <ul class="list-unstyled">
            <li><a href="" class="text-white text-decoration-none">Terms & Conditions</a></li>
            <li><a href="?page=membership-plans" class="text-white text-decoration-none">Membership Plans</a></li>
            <li><a href="" class="text-white text-decoration-none">Contact Us</a></li>
          </ul>
        </div>

        <div class="col-12 col-md-4 mb-1">
          <ul class="list-unstyled mb-1">
            <li class="subheading"><a href="" class="text-white text-decoration-none">About GymBoost</a></li>
          </ul>
          <ul class="list-unstyled">
            <li><a href="" class="text-white text-decoration-none">About Us</a></li>
            <li><a href="?page=faqs" class="text-white text-decoration-none">FAQs</a></li>
          </ul>
        </div>

        <div class="col-12 col-md-4 text-center text-md-start">
          <ul class="list-unstyled mb-1">
            <li class="subheading "><a href="" class="text-white text-decoration-none">Join Us</a></li>
          </ul>
          <ul class="list-unstyled d-flex justify-content-center justify-content-md-start">

            <li class="me-3">
              <a href="https://github.com" class="text-white">
                <i class="bi bi-github"></i>
              </a>
            </li>
            <li class="me-3">
              <a href="https://twitter.com" class="text-white">
                <i class="bi bi-twitter"></i>
              </a>
            </li>
            <li class="me-3">
              <a href="https://facebook.com" class="text-white">
                <i class="bi bi-facebook"></i>
              </a>
            </li>
            <li class="me-3">
              <a href="https://instagram.com" class="text-white">
                <i class="bi bi-instagram"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <hr class="text-white my-4">
      <div class="row align-items-center">
        <div class="col-12 text-center text-md-start mb-3 mb-md-0">
          <p class="mb-0">&copy; 2026 GymBoost. All rights reserved.</p>
          <p class="mb-0">Purok 1, Maharlika Highway, Brgy. San Rafael, Sto. Tomas City, Batangas.</p>
        </div>
      </div>
    </div>
  </footer>


  <script src="assets/js/web.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>

</html>