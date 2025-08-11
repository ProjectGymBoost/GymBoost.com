<?php
session_start();
require_once("../assets/shared/connect.php");
include("../assets/shared/auth.php");
include("../assets/php/processes/admin/settings.php");
include("../assets/php/processes/forgotpassword/phpmailer.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Settings</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
</head>

<body>

    <?php include('../assets/shared/sidebar.php'); ?>

    <div class="main px-2 px-md-0" style="margin-left: 70px;">
        <div class="container-fluid py-3 px-4">
            <!-- Page Title -->
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 mb-4">
                    <div class="heading text-center">ACCOUNT SETTINGS</div>
                </div>
            </div>

            <?php include(__DIR__ . "/../assets/php/modals/admin/settings.php"); ?>

            <!-- Card with Account Settings -->
            <div class="d-flex justify-content-center align-items-center">
                <div class="card" style="width: 100%; max-width: 800px; border-radius: 10px; border: 3px solid #000;">

                    <!-- Account Info Section -->
                    <?php if (isset($_SESSION['profileUpdated'])): ?>
                        <input type="hidden" id="profileUpdatedFlag" value="true">
                        <?php unset($_SESSION['profileUpdated']); ?>
                    <?php endif; ?>

                    <div class="card-body p-4">
                        <h5 class="mb-4">Personal Information</h5>
                        <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 1rem 0;">

                        <div class="row mb-3">
                            <label class="col-4 col-md-2 col-form-label"><b>Name</b></label>
                            <div class="col-8 col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="editFullName" name="fullName"
                                        value="<?= htmlspecialchars($userInfoArray['firstName'] . ' ' . $userInfoArray['lastName']) ?? ''; ?>"
                                        disabled>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editNameModal">
                                        <i class="bi bi-pencil-square"></i>
                                        <span class="d-none d-sm-inline">CHANGE</span>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Email -->
                        <div class="row mb-3">
                            <label class="col-4 col-md-2 col-form-label"><b>Email</b></label>
                            <div class="col-8 col-md-10">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" placeholder="Enter email"
                                        value="<?php echo $userInfoArray['email'] ?? 'N/A'; ?>" disabled>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editAccountEmailModal">
                                        <i class="bi bi-pencil-square"></i>
                                         <span class="d-none d-sm-inline">CHANGE</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <label class="col-4 col-md-2 col-form-label"><b>Password</b></label>
                            <div class="col-8 col-md-10">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="********" name="password"
                                        disabled>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editAccountPassModal">
                                        <i class="bi bi-pencil-square"></i>
                                        <span class="d-none d-sm-inline">CHANGE</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Account Deletion Section -->
                    <div class="card-body p-4">
                        <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 1rem 0;">
                        <h5 class="mb-2">Account Deletion</h5>
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <p class="mb-0">Once deleted, your account can no longer be retrieved.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#deleteAccountModal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/settings.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.toggle-password').forEach(function (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const passwordField = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        passwordField.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            });
        });
    </script>

</body>

</html>