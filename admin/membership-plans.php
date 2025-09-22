<?php
session_start();
include("../assets/shared/auth.php");
include(__DIR__ . '/../assets/shared/connect.php');
include(__DIR__ . '/../assets/php/processes/admin/membership-plans.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Membership Plans</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
    <style>
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
            color: #dc3545 !important;
        }
    </style>
</head>

<body>

    <?php include('../assets/shared/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main px-2 px-md-0" style="margin-left: 70px; transition: margin-left 0.25s ease-in-out;">
        <div class="container-fluid py-4 px-4">

            <!-- Heading -->
            <div class="col-12 mb-4">
                <div class="heading text-center text-sm-start">MEMBERSHIP PLANS</div>
            </div>

            <!-- Controls Form -->
            <form method="GET" action="" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <!-- Sort By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="max-width: 210px;">
                    <select name="sortBy" class="form-select" onchange="this.form.submit()">
                        <option disabled>Sort By</option>
                        <option value="membershipID" <?= ($_GET['sortBy'] ?? '') === 'membershipID' ? 'selected' : '' ?>>
                            Membership Plan ID
                        </option>
                        <option value="planType" <?= ($_GET['sortBy'] ?? '') === 'planType' ? 'selected' : '' ?>>
                            Plan Type</option>
                        <option value="validity" <?= ($_GET['sortBy'] ?? '') === 'validity' ? 'selected' : '' ?>>
                            Validity</option>
                        <option value="price" <?= ($_GET['sortBy'] ?? '') === 'price' ? 'selected' : '' ?>>
                            Price</option>
                    </select>
                </div>

                <!-- Order By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="max-width: 160px;">
                    <select name="orderBy" class="form-select" onchange="this.form.submit()">
                        <option disabled>Order</option>
                        <option value="ASC" <?= strtoupper($_GET['orderBy'] ?? '') === 'ASC' ? 'selected' : '' ?>>
                            Ascending</option>
                        <option value="DESC" <?= strtoupper($_GET['orderBy'] ?? '') === 'DESC' ? 'selected' : '' ?>>
                            Descending</option>
                    </select>
                </div>

                <input type="hidden" name="entriesCount" value="<?= htmlspecialchars($_GET['entriesCount'] ?? 5) ?>">
            </form>


            <!-- Pagination and Add New Button -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="">
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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMembershipModal">ADD
                    NEW</button>
            </div>


            <!-- User Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">PLAN TYPE</th>
                                <th scope="col">VALIDITY</th>
                                <th scope="col">PRICE</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($membershipPlanInfoArray)): ?>
                                <tr>
                                    <td colspan="5" class="text-center" style="color: #D2042D; font-weight: bold;">NO
                                        MEMBERSHIP
                                        PLAN
                                        DATA AVAILABLE</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($membershipPlanInfoArray as $info): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($info['membershipID']) ?></td>
                                        <td><?= htmlspecialchars($info['planType']) ?></td>
                                        <td><?= htmlspecialchars($info['validity']) ?></td>
                                        <td>₱<?= htmlspecialchars(number_format($info['price'], 2)) ?></td>
                                        <td style="display: flex; justify-content: center;">
                                            <li>
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#editMembershipPlanModal<?= $info['membershipID'] ?>">
                                                    <i class="bi bi-pencil-square px-2"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#deleteMembershipPlanModal<?= $info['membershipID'] ?>"
                                                    style="color:red;">
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
            </div>

             <!-- Membership Plan Modals -->
                        <?php include('../assets/php/modals/admin/membership-plans.php'); ?>


            <!-- Bottom Pagination Info -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing <?= $startEntry ?> to <?= $endEntry ?> of <?= $totalEntries ?> entries
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-3">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage - 1 ?>&entriesCount=<?= htmlspecialchars(trim($entriesCount)) ?>&sortBy=<?= urlencode(trim($sortBy)) ?>&orderBy=<?= urlencode(trim($orderBy)) ?>">
                                    &laquo;
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <?php $isActive = $i == $currentPage; ?>
                            <li class="page-item <?= $isActive ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $i ?>&entriesCount=<?= htmlspecialchars(trim($entriesCount)) ?>&sortBy=<?= urlencode(trim($sortBy)) ?>&orderBy=<?= urlencode(trim($orderBy)) ?>"
                                    style="<?= $isActive ? 'background-color: var(--primaryColor); color: white; border: none;' : 'background-color: #ffffff; color: #000000;' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage + 1 ?>&entriesCount=<?= htmlspecialchars(trim($entriesCount)) ?>&sortBy=<?= urlencode(trim($sortBy)) ?>&orderBy=<?= urlencode(trim($orderBy)) ?>">
                                    &raquo;
                                </a>
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

    <script src="../assets/js/membership-plans.js"></script>
</body>

</html>