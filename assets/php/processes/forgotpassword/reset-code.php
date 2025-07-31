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
    <title>OTP Verification</title>
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
        }

        input.is-invalid {
            border-color: #dc3545;
            border-width: 2px !important;
        }

        .invalid-feedback {
            position: absolute;
        }

        #password.is-valid {
            background-position: right 40px center !important;
        }

        #password.is-invalid {
            background-position: right 40px center !important;
        }

        .toggle-password {
            position: absolute !important;
            background-position: right 10px center !important;
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
                    <div class="heading mb-2">OTP VERIFICATION</div>
                    <div class="enter-email mb-3">Enter the OTP sent to your email.</div>
                    <div style="max-width: 400px; width: 100%;" class="mb-4 position-relative">
                        <input type="text" placeholder="Enter OTP" name="otp" id="otp"
                            class="form-control <?php echo !empty($errors['otp']) ? 'is-invalid' : ''; ?>"
                            value="<?php echo htmlspecialchars($_POST['otp'] ?? ''); ?>" required pattern="\d{6}">

                        <div id="otpError" class="invalid-feedback text-start">
                            <?php if (!empty($errors['otp']))
                                echo $errors['otp']; ?>
                        </div>
                    </div>


                    <button name="btnReset" type="submit" class="btn btn-primary w-100 mt-3 mb-2"
                        style="max-width: 400px; display: inline-block; text-align: center;">
                        SUBMIT
                    </button>
                 <!-- Go back to login -->
                    <div class="forgot-link p-1" style="max-width: 400px; width: 100%; text-align: left;">
                        <a href="../../../../login.php" class="login-link">Go back to login</a>
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