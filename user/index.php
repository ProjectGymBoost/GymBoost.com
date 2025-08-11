<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("../assets/shared/connect.php");
include(__DIR__ . '/../assets/php/processes/forgotpassword/phpmailer.php');
include(__DIR__ . '/../assets/php/processes/user/profile.php');
include(__DIR__ . '/../assets/php/classes/classes.php');

$userID = $_SESSION['userID'];
$email = $_SESSION['email'] ?? "";

// Redirects
if (empty($_SESSION['userID']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET["logout"]) && $_GET["logout"] === "true") {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] === 'admin') {
    header("Location: ../admin/index.php");
    exit();
}

$userID = $_SESSION['userID'];
$_SESSION['lastVisited'] = $_SERVER['REQUEST_URI'];
$email = $_SESSION['email'] ?? "";



include(__DIR__ . '/../assets/php/processes/user/achievements.php');

$page = "dashboard";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case "dashboard":
            $page = "dashboard";
            break;
        case "workout":
            $page = "workout";
            break;
        case "achievements":
            $page = "achievements";
            break;
        case "profile":
            $page = "profile";
            break;
        default:
            header("Location: ?page=dashboard");
            break;
    }
} else {
    header("Location: ?page=dashboard");
}

$calendar = new WorkoutCalendar();

if ($userID) {
    $calendar->handleWorkoutActions($userID);
    $calendar->loadEvents($userID);
}
$eventsJSON = $calendar->getEvents();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | User</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/user.css" rel="stylesheet" />
    <style>
        /* CSS for Profile Pic */
        .border-updated {
            border: 4px solid green;
            transition: border 0.5s ease;
        }

        .border-normal {
            border: 2px solid #000;
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
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <div class="container-fluid px-0 fixed-top">
        <nav class="navbar navbar-expand-lg px-3 custom-navbar">
            <!-- Logo -->
            <a class="navbar-brand" href="?page=dashboard">
                <img src="../assets/img/logo/officialLogo.png" width="40" height="40" alt="Logo">
            </a>

            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links & Profile -->
            <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarNav">
                <ul class="navbar-nav mx-auto text-start text-lg-center" style="font-weight:bold;">
                    <li class="nav-item py-1 px-1">
                        <a class="nav-link px-4 py-1 <?php if ($page == 'dashboard')
                            echo 'active'; ?>" href="?page=dashboard">MEMBERSHIP DASHBOARD</a>
                    </li>
                    <li class="nav-item py-1 px-1">
                        <a class="nav-link px-4 py-1 <?php if ($page == 'workout')
                            echo 'active'; ?>" href="?page=workout">WORKOUT CENTRAL</a>
                    </li>
                    <li class="nav-item py-1 pb-2 px-1">
                        <a class="nav-link px-4 py-1 <?php if ($page == 'achievements')
                            echo 'active'; ?>" href="?page=achievements">ACHIEVEMENTS</a>
                    </li>
                </ul>

                <!-- Profile Dropdown -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown px-1">
                        <a class="nav-link <?php echo $profileActive; ?>" href="?page=profile" id="profileDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="display: flex; align-items: center; gap: 8px; padding: 0; cursor: pointer;">
                            <img src="../assets/img/profile/<?php echo $pfpFileName ?>" alt="Profile" width="40"
                                height="40" class="rounded-circle d-none d-lg-block"
                                style="object-fit: cover; outline: none;" />
                            <span class="profile-text d-block d-lg-none px-4 py-1 <?php if ($page == 'profile')
                                echo 'active'; ?>" style="font-weight: bold;">
                                PROFILE
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="?page=profile"><i class="bi bi-gear px-1"></i>
                                    Account</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="?logout=true"><i
                                        class="bi bi-box-arrow-right px-1"></i>
                                    Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div id="mainContent" class="flex-grow-1" style="margin-top: 87px;">
        <div style="overflow-x: hidden;">

            <?php include("views/" . $page . ".php"); ?>
            <?php include(__DIR__ . "/../assets/php/modals/user/profile.php"); ?>
            <?php include(__DIR__ . "/../assets/php/modals/user/achievements.php"); ?>
            <?php include(__DIR__ . "/../assets/php/modals/user/workout.php"); ?>

        </div>
    </div>

    <script src="../assets/js/profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelectorAll('.navbar-nav .nav-link').forEach(el => el.classList.remove('active'));
                link.classList.add('active');
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            const profileImage = document.getElementById('profilePreview');

            if (profileImage.classList.contains('border-updated')) {
                setTimeout(() => {
                    profileImage.classList.remove('border-updated');
                    profileImage.classList.add('border-normal');
                }, 3000);
            }
        });

        // Function for profile pic preview
        function attachProfilePreview() {
            const browseImageInput = document.getElementById('fileInput');
            const profilePicPreview = document.getElementById('profilePreview2');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (browseImageInput && profilePicPreview && fileNameDisplay) {
                browseImageInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        fileNameDisplay.value = file.name;

                        const reader = new FileReader();
                        reader.onload = function (event) {
                            profilePicPreview.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        fileNameDisplay.value = '';
                        console.error('Invalid file type selected.');
                    }
                });
            } else {
                console.error('Required elements not found.');
            }
        }
        attachProfilePreview();

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

        document.addEventListener("DOMContentLoaded", function () {
            var modalToShow = "<?php echo isset($modalToShow) ? $modalToShow : ''; ?>";

            if (modalToShow) {
                var modal = new bootstrap.Modal(document.getElementById(modalToShow));
                modal.show();
            }
        });

        window.currentPage = "<?php echo $page; ?>";
        window.showBadge = <?php echo isset($showNewBadge) && $showNewBadge ? 'true' : 'false'; ?>;
        window.newlyEarnedBadges = <?php echo json_encode($newlyEarnedBadges ?? []); ?>;
        window.modalToShow = "<?php echo isset($modalToShow) ? $modalToShow : ''; ?>";
    </script>
    <script src="../assets/js/badges.js"></script>
</body>

</html>