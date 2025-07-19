<?php
session_start();
include("../assets/shared/auth.php");

include("../assets/shared/connect.php");
include("../assets/php/processes/admin/membership.php");

// Flash message handling
if (isset($_SESSION['membershipDeleted'])) {
    $membershipDeleted = $_SESSION['membershipDeleted'];
    unset($_SESSION['membershipDeleted']);
}
$showDeleteModal = isset($membershipDeleted);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Membership</title>
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

            <!-- Heading -->
            <div class="col-12 mb-4">
                <div class="heading text-center text-sm-start">MEMBERSHIP</div>
            </div>

            <!-- Controls: Search Sort By, Order By, Apply Button -->
            <form method="GET" action="" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <div class="flex-grow-1 input-group" style="max-width: 400px;">
                    <input type="search" name="search" id="searchInput" class="form-control" placeholder="Search members..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
                <div class="flex-grow-1" style="max-width: 160px;">
                    <select name="sortBy" class="form-select">
                        <option disabled>Sort By</option>
                        <option value="rfidNumber" <?= $sortBy === 'rfidNumber' ? 'selected' : '' ?>>RFID Number</option>
                        <option value="firstName" <?= $sortBy === 'firstName' ? 'selected' : '' ?>>First Name</option>
                        <option value="lastName" <?= $sortBy === 'lastName' ? 'selected' : '' ?>>Last Name</option>
                        <option value="startDate" <?= $sortBy === 'startDate' ? 'selected' : '' ?>>Start Date</option>
                        <option value="endDate" <?= $sortBy === 'endDate' ? 'selected' : '' ?>>Expiry Date</option>
                    </select>
                </div>
                <div class="flex-grow-1" style="max-width: 160px;">
                    <select name="orderBy" class="form-select">
                        <option disabled>Order</option>
                        <option value="ASC" <?= $orderBy === 'ASC' ? 'selected' : '' ?>>Ascending</option>
                        <option value="DESC" <?= $orderBy === 'DESC' ? 'selected' : '' ?>>Descending</option>
                    </select>
                </div>
                <input type="hidden" name="entriesCount" value="<?= $entriesCount ?>">
            </form>

            <!-- Entries Count -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="">
                    <div class="small text-muted">
                        Show
                        <select name="entriesCount" class="form-select d-inline-block w-auto mx-1 small text-muted" onchange="this.form.submit()">
                            <option value="5" <?= $entriesCount == 5 ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= $entriesCount == 10 ? 'selected' : '' ?>>10</option>
                            <option value="25" <?= $entriesCount == 25 ? 'selected' : '' ?>>25</option>
                            <option value="50" <?= $entriesCount == 50 ? 'selected' : '' ?>>50</option>
                        </select>
                        entries
                    </div>
                    <input type="hidden" name="search" value="<?= $search ?>">
                    <input type="hidden" name="sortBy" value="<?= $sortBy ?>">
                    <input type="hidden" name="orderBy" value="<?= $orderBy ?>">
                </form>
            </div>

            <!-- User Table -->
            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th>RFID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Start Date</th>
                            <th>Expiry Date</th>
                            <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($membershipArray)): ?>
                            <tr>
                                <td colspan="6" style="color:#D2042D; font-weight: bold; text-align: center;">NO MEMBERSHIP DATA
                                    AVAILABLE</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($membershipArray as $member): ?>
                                <tr>
                                    <td><?= $member['rfidNumber'] ?></td>
                                    <td><?= $member['firstName'] ?></td>
                                    <td><?= $member['lastName'] ?></td>
                                    <td><?= $member['startDate'] ?></td>
                                    <td><?= $member['endDate'] ?></td>
                                    <td class="d-flex flex-row justify-content-center">
                                        <li>
                                            <a data-bs-toggle="modal" data-bs-target="#editMembershipModal<?= $member['userMembershipID']; ?>">
                                                <i class="bi bi-pencil-square px-2"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteMembershipModal<?= $member['userMembershipID']; ?>">
                                                <i class="bi bi-trash3 px-2"></i>
                                            </a>
                                        </li>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            

            <!-- Delete and Edit Modal with their confirmation as well -->
            <?php 
            $membershipInfoArray = $membershipArray; 
            include("../assets/php/modals/admin/membership.php"); 
            ?>


            <!-- Bottom Pagination Info -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing <?= $startEntry ?> to <?= $endEntry ?> of <?= $totalEntries ?> entries
                </div>

                <nav aria-label="Page navigation">
                    <ul class="pagination mt-3">
                        <!-- Previous Arrow -->
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage - 1 ?>&entriesCount=<?= $entriesCount ?>&search=<?= htmlspecialchars($search) ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
                                    aria-label="Previous">&laquo;</a>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <?php $isActive = $i == $currentPage; ?>
                            <li class="page-item <?= $isActive ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $i ?>&entriesCount=<?= $entriesCount ?>&search=<?= htmlspecialchars($search) ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
                                    style="<?= $isActive ? 'background-color: var(--primaryColor); color: white; border: none;' : 'background-color: #ffffff; color: #000000;' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Arrow -->
                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage + 1 ?>&entriesCount=<?= $entriesCount ?>&search=<?= htmlspecialchars($search) ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
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
                }, 500);
            });
        });

        // FOCUS BACK TO SEARCH INPUT AFTER RELOAD
        if (searchInput && searchInput.value) {
            setTimeout(() => {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }, 100);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortOrderForm = document.querySelector("form[method='get']");
            
            if (sortOrderForm) {
                sortOrderForm.querySelectorAll("select[name='sortBy'], select[name='orderBy']").forEach(select => {
                    select.addEventListener('change', () => {
                        sortOrderForm.submit();
                    });
                });
            }
        });
    </script>
</body>

</html>