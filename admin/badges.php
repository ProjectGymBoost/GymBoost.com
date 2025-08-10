<?php
session_start();
include("../assets/shared/auth.php");
include("../assets/shared/connect.php");
include("../assets/php/processes/admin/badges.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Badges</title>
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
        <!-- (BADGES) -->
        <div class="container-fluid py-4 px-4">

            <!-- Heading -->
            <div class="col-12 mb-4">
                <div class="heading text-center text-sm-start">BADGES</div>
            </div>

            <!-- Add New Button -->
            <div class="d-flex justify-content-end align-items-center mb-3">
                <button class="btn btn-primary subheading" data-bs-toggle="modal" data-bs-target="#addBadgeModal">ADD
                    NEW</button>
            </div>

            <!-- Badge Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">BADGE</th>
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">VALUE</th>
                                <th scope="col">ICON</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- Badge Data -->
                        <?php if (empty($badgeInfoArray)): ?>
                            <tr>
                                <td colspan="5" style="color:#D2042D; font-weight: bold; text-align: center;">NO BADGE
                                    DATA AVAILABLE</td>
                            </tr>
                        <?php endif; ?>
                        <tbody>
                            <?php foreach ($badgeInfoArray as $info): ?>
                                <tr>
                                    <td><?= htmlspecialchars($info['badgeID']) ?></td>
                                    <td><?= htmlspecialchars(substr($info['badgeName'], 0, length: 20)) ?><?= strlen($info['badgeName']) > 20 ? '...' : '' ?>
                                    </td>
                                    <td><?= htmlspecialchars(substr($info['description'], 0, length: 40)) ?><?= strlen($info['description']) > 40 ? '...' : '' ?>
                                    </td>
                                    <td><?= htmlspecialchars($info['requirementValue']) ?></td>
                                    <td><?= htmlspecialchars(substr($info['iconUrl'], 0, 20)) ?><?= strlen($info['iconUrl']) > 20 ? '...' : '' ?>
                                    </td>
                                    <td style="display: flex; justify-content: center;">
                                        <li>
                                            <a data-bs-toggle="modal"
                                                data-bs-target="#editBadgeModal<?php echo $info['badgeID']; ?>">
                                                <i class="bi bi-pencil-square px-2"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a style="color: red;" data-bs-toggle="modal"
                                                data-bs-target="#deleteBadgeModal<?php echo $info['badgeID']; ?>">
                                                <i class="bi bi-trash3 px-2"></i>
                                            </a>
                                        </li>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- (USER-BADGES) -->
        <div class="container-fluid py-4 px-4">
            <!-- Heading -->
            <div id="userBadgeSection" class="col-12 mb-4">
                <div class="heading text-center text-sm-start">USER BADGES</div>
            </div>

            <form method="GET" action="#userBadgeSection" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
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
                        <option value="none" <?= ($_GET['sortBy'] ?? '') === 'none' ? 'selected' : '' ?>>User Badge ID
                        </option>
                        <option value="badgeID" <?= ($_GET['sortBy'] ?? '') === 'badgeID' ? 'selected' : '' ?>>Badge ID
                        </option>
                        <option value="username" <?= ($_GET['sortBy'] ?? '') === 'username' ? 'selected' : '' ?>>Name
                        </option>
                        <option value="dateEarned" <?= ($_GET['sortBy'] ?? '') === 'dateEarned' ? 'selected' : '' ?>>Date
                            Earned
                        </option>
                    </select>
                </div>

                <!-- Order By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="max-width: 160px;">
                    <select name="orderBy" class="form-select">
                        <option disabled>Order</option>
                        <option value="ASC" <?= strtoupper($_GET['orderBy'] ?? '') === 'ASC' ? 'selected' : '' ?>>Ascending
                        </option>
                        <option value="DESC" <?= strtoupper($_GET['orderBy'] ?? '') === 'DESC' ? 'selected' : '' ?>>
                            Descending</option>
                    </select>
                </div>
                <input type="hidden" name="entriesCount" value="<?php echo $entriesCount; ?>">
            </form>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="#userBadgeSection">
                    <div class="small text-muted">
                        Show
                        <select name="entriesCount" class="form-select d-inline-block w-auto mx-1 small text-muted"
                            onchange="this.form.submit()">
                            <option value="5" <?= ($_GET['entriesCount'] ?? '') == '5' ? 'selected' : '' ?>>5
                            </option>
                            <option value="10" <?= ($_GET['entriesCount'] ?? '') == '10' ? 'selected' : '' ?>>10
                            </option>
                            <option value="25" <?= ($_GET['entriesCount'] ?? '') == '25' ? 'selected' : '' ?>>25
                            </option>
                            <option value="50" <?= ($_GET['entriesCount'] ?? '') == '50' ? 'selected' : '' ?>>50
                            </option>
                        </select>
                        entries
                    </div>
                    <input type="hidden" name="search" value="<?php echo $search; ?>">
                    <input type="hidden" name="sortBy" value="<?php echo $sortBy; ?>">
                    <input type="hidden" name="orderBy" value="<?php echo $orderBy; ?>">
                </form>
            </div>

            <!-- User Badge Table -->
            <div class="row">
                <div class="table-responsive">
                    <table id="userBadgeTable" class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">BADGE ID</th>
                                <th scope="col">USERNAME</th>
                                <th scope="col">DATE EARNED</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- User Badge Data -->
                        <?php if (empty($userBadgeInfoArray)): ?>
                            <tr>
                                <td colspan="5" style="color:#D2042D; font-weight: bold; text-align: center;">NO USER BADGE
                                    DATA AVAILABLE</td>
                            </tr>
                        <?php endif; ?>
                        <tbody>
                            <?php foreach ($userBadgeInfoArray as $infoAlt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($infoAlt['userBadgeID']) ?></td>
                                    <td><?= htmlspecialchars($infoAlt['badgeID']) ?></td>
                                    <td><?= htmlspecialchars(substr($infoAlt['username'], 0, length: 50)) ?><?= strlen($infoAlt['username']) > 50 ? '...' : '' ?>
                                    </td>
                                    <td><?= htmlspecialchars($infoAlt['dateEarned']) ?></td>
                                    <td>
                                        <li style="display: flex; justify-content: center;">
                                            <a style="color: red" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserBadgeModal<?php echo $infoAlt['userBadgeID']; ?>">
                                                <i class="bi bi-trash3 px-1"></i>
                                            </a>
                                        </li>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bottom Pagination Info -->
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

        <!-- ALL MODALS and CONFIRMATION MODALS -->
        <?php include("../assets/php/modals/admin/badges.php"); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DEBOUNCE SEARCH AUTO SUBMIT
            const form = document.querySelector('form[method="get"]');
            const searchInput = document.getElementById('searchInput');
            let debounceTimer;

            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    form.action = "#userBadgeSection";
                    form.submit();
                }, 500);
            });

            // FOCUS BACK TO SEARCH INPUT AFTER RELOAD
            if (searchInput && searchInput.value) {
                setTimeout(() => {
                    searchInput.focus();
                    searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
                }, 100);
            }

            // SORT AND ORDER AUTO SUBMIT
            document.querySelectorAll("select[name='sortBy'], select[name='orderBy']").forEach(select => {
                select.addEventListener('change', () => {
                    select.form.action = "#userBadgeSection";
                    select.form.submit();
                });
            });

            // JUMP TO USER BADGE SECTION
            if (window.location.hash === "#userBadgeSection") {
                const html = document.documentElement;
                const originalScrollBehavior = html.style.scrollBehavior;
                html.style.scrollBehavior = "auto";

                const target = document.querySelector('#userBadgeSection');
                if (target) {
                    target.scrollIntoView();
                }

                html.style.scrollBehavior = originalScrollBehavior;
            }
        });
    </script>

</body>

</html>