<?php
include("../assets/shared/connect.php");
include("../assets/php/classes/classes.php");
include("../assets/php/processes/admin/register.php");
include("../assets/shared/auth.php");
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
            white-space: normal;
            word-wrap: break-word;
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

                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="accountSelect" class="mb-0 fw-bold"
                                        style="white-space: nowrap; color: var(--text-color-light); font-size: clamp(0.8rem, 2vw, 1.1rem)">Create
                                        an account
                                        for:</label>
                                    <select name="accountSelect" id="accountSelect" class="form-select" required>
                                        <option value="user" <?= ($_POST['accountSelect'] ?? '') === 'user' ? 'selected' : '' ?>>
                                            User</option>
                                        <option value="admin" <?= ($_POST['accountSelect'] ?? '') === 'admin' ? 'selected' : '' ?>>
                                            Admin</option>
                                    </select>
                                </div>
                                <div id="accountSelectError" class="invalid-feedback text-start"></div>
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3 w-100">

                                <!-- First Name -->
                                <div class="w-100 mb-3">
                                    <input type="text" placeholder="First Name" class="form-control" name="firstName"
                                        id="firstName" required style="border-radius: 5px;"
                                        value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
                                    <div id="firstNameError" class="invalid-feedback text-start"></div>
                                    <input type="hidden" id="firstNameExistsError"
                                        value="<?php echo $firstNameError; ?>">
                                </div>

                                <!-- Last Name -->
                                <div class="w-100 mb-3">
                                    <input type="text" placeholder="Last Name" class="form-control" name="lastName"
                                        id="lastName" required style="border-radius: 5px;"
                                        value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
                                    <div id="lastNameError" class="invalid-feedback text-start"></div>
                                    <input type="hidden" id="lastNameExistsError" value="<?php echo $lastNameError; ?>">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="w-100 mb-3">
                                <input type="email" placeholder="Email" class="form-control" name="email" id="email"
                                    style="border-radius: 5px;"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                    required>
                                <div id="emailError" class="invalid-feedback text-start"></div>
                                <input type="hidden" id="emailExistsError"
                                    value="<?php echo htmlspecialchars($emailExistsError); ?>">
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3 mb-3 w-100">
                                <!-- RFID Number -->
                                <div class="flex-grow-1 position-relative mb-3" id="rfidContainer">
                                    <input type="text" placeholder="RFID Number" class="form-control" name="rfid"
                                        id="rfid" style="border-radius: 5px;"
                                        value="<?php echo isset($_POST['rfid']) ? htmlspecialchars($_POST['rfid']) : ''; ?>"
                                        required>
                                    <div id="rfidError" class="invalid-feedback text-start"></div>
                                    <input type="hidden" id="rfidExistsError"
                                        value="<?php echo htmlspecialchars($rfidExistsError); ?>">
                                </div>

                                <!-- Birthday -->
                                <div class="flex-grow position-relative mb-3" id="birthdayContainer">
                                    <i class="bi bi-calendar-date position-absolute"
                                        style="top: 50%; left: 8px; transform: translateY(-50%); color: #888888; font-size: 1rem;"></i>
                                    <input type="text" class="form-control" id="birthday" name="birthday"
                                        placeholder="Birthday" onfocus="(this.type='date')"
                                        onblur="if(!this.value)this.type='text'"
                                        style="border-radius: 5px; padding-left: 2.0rem;" required>
                                    <div id="birthdayError" class="invalid-feedback text-start"></div>
                                </div>


                                <!-- Membership -->
                                <div class="flex-grow-1" id="membershipContainer">
                                    <select class="form-select w-100" name="membershipID" id="membership" required>
                                        <option value="" selected hidden>Membership Plan</option>
                                        <?php
                                        $membershipQuery = "
                                                        SELECT membershipID, planType 
                                                        FROM memberships
                                                        ORDER BY CAST(SUBSTRING_INDEX(validity, ' ', 1) AS UNSIGNED) ASC
                                                    ";
                                        $membershipResult = executeQuery($membershipQuery);
                                        while ($membership = mysqli_fetch_assoc($membershipResult)) {
                                            echo '<option value="' . $membership['membershipID'] . '">' . $membership['planType'] . '</option>';
                                        }
                                        ?>
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
                                <button type="submit" name="btnRegister" class="btn btn-primary mt-2">
                                    CREATE
                                </button>
                                <a class="btn btn-secondary mt-2" href="users.php">CANCEL</a>
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