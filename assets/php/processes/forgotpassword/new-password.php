<?php
include("phpmailer.php");
$email = $_SESSION['email'];
if ($email == false) {
    header('Location: ../../../../login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Change Password</title>
    <link rel="icon" href="../../../img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/styles.css">

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
            background-position: right 2.5rem center !important;
        }

        input.is-invalid {
            border-color: #dc3545;
            border-width: 2px !important;
            background-position: right 2.5rem center !important;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--primaryColor);
            text-shadow: 0 0 1px var(--primaryColor);
            z-index: 3;
            pointer-events: auto;
        }

        .invalid-feedback {
            position: absolute;
            left: 0;
            bottom: -25px;
            font-size: 0.875em;
        }

        #password.is-valid {
            background-position: right 40px center !important;
        }

        #password.is-invalid {
            background-position: right 40px center !important;
        }
    </style>
</head>

<body style="background-color: var(--bgColor); height: 100vh; margin: 0; overflow: hidden;">

    <form method="POST">
        <nav class="navbar" style="background-color: var(--primaryColor);">
            <div class="container d-flex justify-content-center align-items-center" style="height: 100%;">
                <a class="navbar-brand m-0" href="../../../../login.php">
                    <img src="../../../img/logo/officialLogo.png" alt="logo" width="40" height="40"
                        style="display: block;">
                </a>
            </div>
        </nav>

        <div class="container-fluid p-0" style="height: calc(100vh - 56px);">
            <div class="row m-0" style="height: 100%;">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center text-center p-4"
                    style="height: 100%; margin-top: -2rem;">
                    <div class="heading mb-2">CREATE NEW PASSWORD</div>
                    <div class="enter-email mb-3">All passwords must be atleast 8 characters.</div>
                    <div style="max-width: 400px; width: 100%;" class="mb-4 position-relative">
                        <!-- Create Password -->
                        <div class="position-relative w-100 mb-4">
                            <input type="password" placeholder="Create a Password" class="form-control" name="password"
                                id="password" required style="border-radius: 5px;">
                            <i class="bi bi-eye-slash toggle-password" data-target="password" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor);
     text-shadow: 0 0 1px var(--primaryColor);"></i>
                            <div id="passwordError" class="invalid-feedback text-start"></div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="position-relative w-100 mb-4 mt-1">
                            <input type="password" id="confirmPassword" class="form-control" name="confirmPassword"
                                placeholder="Confirm Password" required style="border-radius: 5px;">
                            <i class="bi bi-eye-slash toggle-password" data-target="confirmPassword"></i>
                            <div id="confirmPasswordError" class="invalid-feedback text-start"></div>
                        </div>
                    </div>

                    <button name="btnChange" type="submit" class="btn btn-primary w-100  mb-2"
                        style="max-width: 400px; display: inline-block; text-align: center;">
                        CHANGE
                    </button>
                 <!-- Go back to login -->
                    <div class="forgot-link p-1" style="max-width: 400px; width: 100%; text-align: left;">
                        <a href="../../../../login.php" class="login-link">Go back to login</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const togglePasswordIcons = document.querySelectorAll(".toggle-password");

                togglePasswordIcons.forEach(icon => {
                    icon.addEventListener("click", function () {
                        const targetId = this.getAttribute("data-target");
                        const targetInput = document.getElementById(targetId);

                        if (targetInput) {
                            const type = targetInput.getAttribute("type") === "password" ? "text" : "password";
                            targetInput.setAttribute("type", type);

                            this.classList.toggle("bi-eye");
                            this.classList.toggle("bi-eye-slash");
                        }
                    });
                });
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