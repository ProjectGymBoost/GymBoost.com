<?php 
include ("phpmailer.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Password Changed</title>
    <link rel="icon" href="../../../img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/styles.css">
</head>

<body style="background-color: var(--bgColor); height: 100vh; margin: 0; overflow: hidden;">

    <form method="POST">
        <nav class="navbar" style="background-color: var(--primaryColor);">
            <div class="container d-flex justify-content-center align-items-center" style="height: 100%;">
                <a class="navbar-brand m-0">
                    <img src="../../../img/logo/officialLogo.png" alt="logo" width="40" height="40"
                        style="display: block;">
                </a>
            </div>
        </nav>

        <div class="container-fluid p-0" style="height: calc(100vh - 56px);">
            <div class="row m-0" style="height: 100%;">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center text-center p-4"
                    style="height: 100%; margin-top: -2rem;">
                    <div class="heading mb-2">PASSWORD CHANGED SUCCESSFULLY</div>

                      <div class="subheading mb-2">
                        <a href="../../../../login.php" style="color: inherit">
                        Go to Login
                        </a>
                    </div>
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

        <script src="../../../js/mailer.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
</body>

</html>