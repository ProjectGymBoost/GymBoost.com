<!-- Navbar for phone size -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="../assets/img/logo/officialLogo.png" alt="Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"
            aria-controls="sidebarOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- sidebar -->
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex align-items-center fw-bold">
            <img src="../assets/img/logo/officialLogo.png" id="toggleSidebar" alt="Toggle Sidebar" class="toggle-logo">
            <div class="sidebar-logo mx-auto">
                <a href="#">GYMBOOST</a>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="index.php" class="sidebar-link">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="users.php" class="sidebar-link">
                    <i class="bi bi-person"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="membership-plans.php" class="sidebar-link">
                    <i class="bi bi-credit-card"></i>
                    <span>Membership Plans</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="membership.php" class="sidebar-link">
                    <i class="bi bi-person-vcard"></i>
                    <span>Membership</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="attendance.php" class="sidebar-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Attendance</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="badges.php" class="sidebar-link">
                    <i class="bi bi-patch-check"></i>
                    <span>Badges</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="announcements.php" class="sidebar-link">
                    <i class="bi bi-bell"></i>
                    <span>Announcements</span>
                </a>
            </li>
            <li class="sidebar-item mt-auto">
                <a href="../login.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Offcanvas for phone size -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <img src="../assets/img/logo/officialLogo.png" alt="GYMBOOST" class="img-fluid" id="sidebarOffcanvasLabel"
                style="max-height: 44px; max-width: 200px">
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">
                <li><a href="index.php" class="sidebar-link"><i class="bi bi-bar-chart-line"></i>Dashboard</a></li>
                <li><a href="users.php" class="sidebar-link"><i class="bi bi-person"></i> Users</a></li>
                <li><a href="membership-plans.php" class="sidebar-link"><i class="bi bi-credit-card"></i> Membership Plans</a></li>
                <li><a href="membership.php" class="sidebar-link"><i class="bi bi-person-vcard"></i> Memberships</a></li>
                <li><a href="attendance.php" class="sidebar-link"><i class="bi bi-calendar-check"></i> Attendance</a></li>
                <li><a href="badges.php" class="sidebar-link"><i class="bi bi-patch-check"></i> Badges</a></li>
                <li><a href="announcements.php" class="sidebar-link"><i class="bi bi-bell"></i> Announcements</a></li>
                <li><a href="../login.php" class="sidebar-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function () {
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.querySelector(".main");
            sidebar.classList.toggle("expand");
            if (sidebar.classList.contains("expand")) {
                mainContent.style.marginLeft = "260px";
            } else {
                mainContent.style.marginLeft = "70px";
            }
        });
        document.addEventListener("DOMContentLoaded", () => {
            const pathName = window.location.pathname;
            const links = document.querySelectorAll(".sidebar-link");
            links.forEach(link => {
                const linkHref = link.getAttribute("href");
                if (pathName.includes(linkHref)) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        });
    </script>