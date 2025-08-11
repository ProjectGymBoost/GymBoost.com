<?php
session_start();
if (!empty($_SESSION['userID'])) {
  if ($_SESSION['role'] === 'admin') {
    echo "<script>window.location.replace('admin/index.php');</script>";
    exit();
  } else {
    echo "<script>window.location.replace('user/index.php?page=dashboard');</script>";
    exit();
  }
}
include("assets/shared/connect.php");
include("assets/php/classes/classes.php");
include("assets/php/processes/login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="icon" href="assets/img/logo/officialLogo.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet" />

  <style>
    .form-control:focus {
      border-color: var(--primaryColor);
      border-width: 2px;
      box-shadow: none;
    }

    .forgot-link {
      text-decoration: none;
      color: var(--bs-secondary);
      transition: color 0.3s ease;
    }

    .forgot-link:hover {
      color: var(--primaryColor);
    }

    input.is-valid {
      border-color: #28a745;
      border-width: 2px !important;
    }

    input.is-invalid {
      border-color: #dc3545;
      border-width: 2px !important;
    }

    .invalid-feedback {
      position: absolute;
    }

    #password.is-valid,
    #password.is-invalid {
      background-position: right 40px center !important;
    }
  </style>
</head>

<body style="background-color: var(--bgColor); height: 100vh; margin: 0; overflow: hidden;">

  <form method="POST">
    <?php if (isset($_SESSION['loginError'])): ?>
      <div id="loginError" style="display: none;">
        <?php echo htmlspecialchars($_SESSION['loginError']); ?>
      </div>
      <?php unset($_SESSION['loginError']); // Clear the error after it's used ?>
    <?php endif; ?>



    <!-- Navbar -->
    <nav class="navbar" style="background-color: var(--primaryColor);">
      <div class="container d-flex justify-content-center align-items-center" style="height: 100%;">
        <a class="navbar-brand m-0" href="index.php">
          <img src="assets/img/logo/officialLogo.png" alt="logo" width="40" height="40" style="display: block;">
        </a>
      </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid p-0" style="height: calc(100vh - 56px);">
      <div class="row m-0" style="height: 100%;">

        <!-- Left Column (Form) -->
        <div class="col-12 col-xl-6 d-flex flex-column justify-content-center align-items-center text-center p-4"
          style="height: 100%; margin-top: -2rem;">
          <div class="heading mb-5">LOGIN</div>

          <!-- Email -->
          <div class="form-floating" style="max-width: 400px; width: 100%;">
            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
            <label for="email">Email address</label>
            <div id="emailError" class="invalid-feedback text-start"></div>
          </div>

          <!-- Password -->
          <div class="position-relative mt-4 mb-4" style="max-width: 400px; width: 100%;">
            <div class="form-floating">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
              <label for="password">Password</label>
              <div id="passwordError" class="invalid-feedback text-start"></div>
              <i class="bi bi-eye-slash position-absolute" id="togglePassword"
                style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor); text-shadow: 0 0 1px var(--primaryColor);"></i>

              <!-- Display the login error if exists -->
              <?php if (!empty($loginError)): ?>
                <div id="loginError" class="invalid-feedback text-start">
                  <?php echo htmlspecialchars($loginError); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>


          <!-- Login Button -->
          <button name="btnLogin" type="submit" class="btn btn-primary w-100 mt-2 mb-2"
            style="max-width: 400px; font-family: var(--primaryFont);">
            LOGIN
          </button>

          <!-- Forgot Password -->
          <div class="forgot-link p-1" style="max-width: 400px; width: 100%; text-align: left;">
            <a href="assets/php/processes/forgotpassword/forgot-password.php" class="forgot-link">Forgot your
              password?</a>
          </div>
        </div>

        <!-- Right Column (Image) -->
        <div class="col-12 col-xl-6 d-none d-lg-block p-0" style="height: 100%;">
          <img src="assets/img/logo/backupLogo2.png" alt="Display Image"
            style="width: 100%; height: 100%; object-fit: fill; display: block;">
        </div>

      </div>
    </div>
  </form>

  <!-- JS -->
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
      togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
      });
    }
  </script>

  <script src="assets/js/login.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script>
    <?php if (!empty($_SESSION['userID'])): ?>
      window.location.replace("<?php echo ($_SESSION['role'] === 'admin') ? '/admin/index.php' : '/user/index.php?page=dashboard'; ?>");
    <?php endif; ?>
  </script>

</body>

</html>