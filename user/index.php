<?php
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
        case "rewards":
            $page = "rewards";
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

</head>

<body style="background-color: var(--bgColor);">
    <!-- Navbar -->
    <div class="container-fluid px-0 fixed-top">
        <nav class="navbar navbar-expand-lg px-3 custom-navbar">
            <!-- Logo -->
            <a class="navbar-brand">
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
                    <li class="nav-item py-1">
                        <a class="nav-link px-4 py-1 <?php if ($page == 'dashboard')
                            echo 'active'; ?>" href="?page=dashboard">MEMBERSHIP DASHBOARD</a>
                    </li>
                    <li class="nav-item py-1">
                        <a class="nav-link px-4 py-1 <?php if ($page == 'workout')
                            echo 'active'; ?>" href="?page=workout">WORKOUT CENTRAL</a>
                    </li>
                    <li class="nav-item py-1 pb-2">
                        <a class="nav-link px-4 py-1 <?php if ($page == 'rewards')
                            echo 'active'; ?>" href="?page=rewards">ACHIEVEMENTS</a>
                    </li>
                </ul>

                <!-- Profile Dropdown -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link <?php echo $profileActive; ?>" href="?page=profile" id="profileDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="display: flex; align-items: center; gap: 8px; padding: 0; cursor: pointer;">
                            <img src="../assets/img/logo/officialLogo.png" alt="Profile" width="40" height="40"
                                class="rounded-circle d-none d-lg-block" style="object-fit: cover; outline: none;" />
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
                            <li><a class="dropdown-item text-danger" href="../index.php"><i
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
        </div>
    </div>

    <script>
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelectorAll('.navbar-nav .nav-link').forEach(el => el.classList.remove('active'));
                link.classList.add('active');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>