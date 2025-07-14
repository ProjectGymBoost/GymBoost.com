<?php
include("../assets/shared/connect.php");
include("../assets/php/classes/classes.php");
include("../assets/php/processes/admin/register.php");
if (empty($_SESSION['userID'])) {
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['role'] === 'user') {
    header("Location: ../user/index.php");
    exit();
}
if (!empty($_SESSION['userID'])) {
    $_SESSION['lastVisited'] = $_SERVER['REQUEST_URI'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Dashboard</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
    <style>
        /* [Do not remove] */
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
            color: var(--text-color-light) !important;
        }

        select.is-valid {
            border-color: #28a745;
            border-width: 2px !important;
        }

        select.is-invalid {
            border-color: #dc3545;
            border-width: 2px !important;
        }

        #password.is-valid,
        #confirmPassword.is-valid {
            background-position: right 40px center !important;
        }

        #password.is-invalid,
        #confirmPassword.is-invalid {
            background-position: right 40px center !important;
        }

        .toggle-password {
            position: absolute !important;
            background-position: right 10px center !important;
        }
    </style>
</head>

<body>

    <form method="POST">
        <?php include('../assets/shared/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="main px-2 px-md-0" style="margin-left: 70px; transition: margin-left 0.25s ease-in-out;">

            <!-- Heading -->
            <div class="container-fluid py-3 px-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8 mb-4">
                        <div class="heading text-center">CREATE ACCOUNT</div>
                    </div>

                    <!-- Wrapper for horizontal centering -->
                    <div class="d-flex justify-content-center align">
                        <div class="d-flex flex-column align-items-center gap-3 p-3 p-lg-5 card-bg-color"
                            style="width: 100%; max-width: 800px; border-radius: 10px;">
                            <div class="d-flex gap-3 w-100">
                                <!-- First Name -->
                                <div class="w-100 mb-3">
                                    <input type="text" placeholder="First Name" class="form-control" name="firstName"
                                        id="firstName" required style="border-radius: 5px;">
                                    <div id="firstNameError" class="invalid-feedback mb-5 text-start"></div>
                                </div>

                                <!-- Last Name -->
                                <div class="w-100 mb-3">
                                    <input type="text" placeholder="Last Name" class="form-control" name="lastName"
                                        id="lastName" required style="border-radius: 5px;">
                                    <div id="lastNameError" class="invalid-feedback text-start"></div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="w-100 mb-3">
                                <input type="email" placeholder="Email" class="form-control" name="email" id="email"
                                    style="border-radius: 5px;"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                    required>
                                <div id="emailError" class="invalid-feedback text-start"></div>
                                <input type="hidden" id="emailExistsError" class="text-start"
                                    value="<?php echo $emailExistsError; ?>">
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3 mb-3 w-100">
                                <!-- RFID Number -->
                                <div class="flex-grow-1 position-relative">
                                    <input type="text" placeholder="RFID Number" class="form-control" name="rfid"
                                        id="rfid" style="border-radius: 5px;"
                                        value="<?php echo isset($_POST['rfid']) ? htmlspecialchars($_POST['rfid']) : ''; ?>"
                                        required>
                                    <div id="rfidError" class="invalid-feedback text-start"></div>
                                    <input type="hidden" id="rfidExistsError" class="text-start"
                                        value="<?php echo $rfidExistsError?>">
                                </div>

                                <!-- Birthday -->
                                <div class="flex-grow position-relative">
                                    <input type="date" class="form-control w-100" id="birthday" name="birthday"
                                        style="border-radius: 5px;" required>
                                    <div id="birthdayError" class="invalid-feedback text-start"></div>
                                </div>

                                <!-- Membership -->
                                <div class="flex-grow-1">
                                    <select class="form-select w-100" name="membershipID" id="membership" required>
                                        <option selected disabled>Membership Plan</option>
                                        <option value="2">Half Month</option>
                                        <option value="3">1 Month</option>
                                        <option value="4">2 Months</option>
                                        <option value="5">3 Months</option>
                                        <option value="6">Semi Annual</option>
                                        <option value="7">Annual</option>
                                    </select>
                                    <div id="membershipError" class="invalid-feedback text-start"></div>
                                </div>
                            </div>

                            <hr
                                style="border-top: 3px solid var(--primaryColor); opacity: 1; width: 100%; margin: 2rem 0;">

                            <!-- Create Password -->
                            <div class="position-relative w-100 mb-3">
                                <input type="password" placeholder="Create a Password" class="form-control"
                                    name="password" id="password" required style="border-radius: 5px;">
                                <i class="bi bi-eye-slash toggle-password" data-target="password" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor);
     text-shadow: 0 0 1px var(--primaryColor);"></i>
                                <div id="passwordError" class="invalid-feedback text-start"></div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="position-relative w-100 mb-3">
                                <input type="password" placeholder="Confirm Password" name="confirmPassword"
                                    id="confirmPassword" class="form-control" required class="form-control"
                                    style="border-radius: 5px;">
                                <i class="bi bi-eye-slash  toggle-password" data-target="confirmPassword" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor);
     text-shadow: 0 0 1px var(--primaryColor);"></i>
                                <div id="confirmPasswordError" class="invalid-feedback text-start"></div>
                            </div>

                            <!-- Create Button -->
                            <div class="w-100 text-center mt-3">
                                <button type="submit" name="btnRegister" class="btn btn-primary">
                                    CREATE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <script>
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const input = document.getElementById(this.getAttribute('data-target'));
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('bi-eye');
                    this.classList.toggle('bi-eye-slash');
                });
            });
        </script>

        <script src="../assets/js/register.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
            integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
            crossorigin="anonymous"></script>
</body>

</html>