<?php
session_start();
include("../assets/shared/auth.php");
include(__DIR__ . '/../assets/shared/connect.php');
include(__DIR__ . '/../assets/php/processes/admin/attendance.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Attendance</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
</head>

<body>

    <?php include('../assets/shared/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main px-2 px-md-0" style="margin-left: 70px; transition: margin-left 0.25s ease-in-out;">
        <div class="container-fluid py-4 px-4">

            <!-- Heading and Check-in Button -->
            <div class="col-12 mb-4 d-flex align-items-center justify-content-between">
                <div class="heading text-center text-sm-start">ATTENDANCE</div>
                <a href="../checkin.php" target="_blank" rel="noopener noreferrer"><button
                        class="btn btn-primary">Check-in</button></a>
            </div>

            <!-- Controls Form -->
            <form method="GET" action="" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <!-- Search -->
                <div class="flex-grow-1 flex-sm-grow-0 input-group" style="max-width: 400px;">
                    <input type="search" name="search" id="searchInput" class="form-control"
                        placeholder="Search users..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>

                <!-- Sort By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="max-width: 160px;">
                    <select name="sortBy" class="form-select">
                        <option disabled>Sort By</option>
                        <option value="attendanceID" <?= ($_GET['sortBy'] ?? '') === 'attendanceID' ? 'selected' : '' ?>>
                            Attendance ID
                        </option>
                        <option value="firstName" <?= ($_GET['sortBy'] ?? '') === 'firstName' ? 'selected' : '' ?>>
                            First Name</option>
                        <option value="lastName" <?= ($_GET['sortBy'] ?? '') === 'lastName' ? 'selected' : '' ?>>Last
                            Name</option>
                        <option value="checkinDate" <?= ($_GET['sortBy'] ?? '') === 'checkinDate' ? 'selected' : '' ?>>
                            Date</option>
                    </select>
                </div>

                <!-- Order By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="max-width: 160px;">
                    <select name="orderBy" class="form-select">
                        <option disabled>Order</option>
                        <option value="ASC" <?= strtoupper($_GET['orderBy'] ?? '') === 'ASC' ? 'selected' : '' ?>>
                            Ascending</option>
                        <option value="DESC" <?= strtoupper($_GET['orderBy'] ?? '') === 'DESC' || empty($_GET['orderBy']) ? 'selected' : '' ?>>
                            Descending</option>
                    </select>
                </div>


                <input type="hidden" name="entriesCount" value="<?php echo $entriesCount; ?>">
            </form>
            <!-- End Controls Form -->

            <!-- Pagination and Add New Button -->
            <form method="GET" action="" class="d-flex justify-content-between align-items-center mb-3">
                <div class="small text-muted">
                    Show
                    <select name="entriesCount" class="form-select d-inline-block w-auto mx-1 small text-muted"
                        onchange="this.form.submit()">
                        <option value="5" <?= ($_GET['entriesCount'] ?? '') == '5' ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= ($_GET['entriesCount'] ?? '') == '10' ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= ($_GET['entriesCount'] ?? '') == '25' ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= ($_GET['entriesCount'] ?? '') == '50' ? 'selected' : '' ?>>50</option>
                    </select>
                    entries
                </div>
            </form>

            <!-- Attendance Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">FIRST NAME</th>
                                <th scope="col">LAST NAME</th>
                                <th scope="col">DATE</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($userInfoArray)): ?>
                                <tr>
                                    <td colspan="5" class="text-center" style="color: #D2042D; font-weight: bold;">NO
                                        ATTENDANCE
                                        DATA AVAILABLE</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($userInfoArray as $info): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($info['attendanceID']) ?></td>
                                        <td><?= htmlspecialchars($info['firstName']) ?></td>
                                        <td><?= htmlspecialchars($info['lastName']) ?></td>
                                        <td><?= htmlspecialchars($info['checkinDate']) ?></td>
                                        <td>
                                            <li style="display: flex; justify-content: center;">
                                                <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal<?= $info['userID']; ?>">
                                                    <i class="bi bi-trash3 px-1"></i>
                                                </a>
                                            </li>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <!-- Modals -->
                        <?php include('../assets/php/modals/admin/attendance.php'); ?>
                    </table>
                </div>
            </div>
            <!-- End Attendance Table -->

            <!-- Bottom Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing <?= $startEntry ?> to <?= $endEntry ?> of <?= $totalEntries ?> entries
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-3">
                        <?php
                        $range = 1;
                        $start = max(1, $currentPage - $range);
                        $end = min($totalPages, $currentPage + $range);
                        if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage - 1 ?>&entriesCount=<?= $entriesCount ?>&search=<?= $search ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
                                    aria-label="Previous">&laquo;</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <?php $isActive = $i == $currentPage; ?>
                            <li class="page-item <?= $isActive ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $i ?>&entriesCount=<?= $entriesCount ?>&search=<?= $search ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
                                    style="<?= $isActive ? 'background-color: var(--primaryColor); color: white; border: none;' : 'background-color: #ffffff; color: #000000;' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Arrow -->
                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage + 1 ?>&entriesCount=<?= $entriesCount ?>&search=<?= $search ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
                                    aria-label="Next">&raquo;</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[method="get"]');

            let debounceTimer;
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    form.submit();
                }, 2000); // wait 2 seconds before submitting
            });
        });
        if (searchInput && searchInput.value) {
            setTimeout(() => {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }, 100);
        }
    </script>

    <script>
        document.querySelectorAll("select[name='sortBy'], select[name='orderBy']").forEach(select => {
            select.addEventListener('change', () => {
                select.form.submit();
            });
        });
    </script>

    <script>
        document.addEventListener('hidden.bs.modal', function () {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            if (document.querySelectorAll('.modal.show').length === 0) {
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
            }
        });
    </script>

</body>

</html>