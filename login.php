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
  <link href="assets/css/web.css" rel="stylesheet" />
</head>

<body style="background-color: var(--bgColor); height: 100vh; margin: 0; overflow: hidden;">

  <nav class="navbar" style="background-color: var(--primaryColor);">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100%;">
      <a class="navbar-brand m-0">
        <img src="assets/img/logo/officialLogo.png" alt="logo" width="40" height="40" style="display: block;">
      </a>
    </div>
  </nav>

  <div class="container-fluid p-0" style="height: calc(100vh - 56px);">
    <div class="row m-0" style="height: 100%;">
      <!-- First Column -->
      <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-4"
        style="height: 100%; margin-top: -2rem;">
        <div class="heading mb-5">LOGIN</div>
        <input type="email" placeholder="Email" class="form-control mb-4" style="max-width: 400px;">

          <div class="position-relative mb-5" style="max-width: 400px; width: 100%;">
            <input type="password" id="password" placeholder="Password" class="form-control"
              style="border-radius: 5px;">
            <i class="bi bi-eye-slash position-absolute" id="togglePassword" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor);
          text-shadow: 0 0 1px var(--primaryColor);"></i>
          </div>

          <a href="user/index.php" class="btn w-100 mt-2 mb-2"
            style="max-width: 400px; display: inline-block; text-align: center;">
            LOGIN
          </a>

          <div class="forgot-link p-1" style="max-width: 400px; width: 100%; text-align: left;">
            <a href="#" class="forgot-link">Forgot your password?</a>
          </div>
        </div>

      <!-- Second Column -->
      <div class="col-md-6 d-none d-lg-block p-0" style="height: 100%;">
        <!-- Sample Image -->
        <img src="assets/img/logo/backupLogo.png" alt="Display Image"
          style="width: 100%; height: 100%; object-fit: fill; display: block;">
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);

      this.classList.toggle('bi-eye');
      this.classList.toggle('bi-eye-slash');
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
</body>

</html>