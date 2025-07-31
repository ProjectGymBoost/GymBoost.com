<?php
session_start();
include("../assets/shared/auth.php");
include("../assets/shared/connect.php");

$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$entriesCount = isset($_GET['entriesCount']) ? (int) $_GET['entriesCount'] : 5;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : '';

include("../assets/php/processes/admin/announcement.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Announcement</title>
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
                <div class="heading text-center text-sm-start">ANNOUNCEMENT</div>
            </div>

            <!-- Pagination and Add New Button -->
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
                </form>

                <!-- Add New Button -->
                <a class="btn btn-primary subheading" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                    ADD NEW
                </a>

            </div>

            <!-- User Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">MESSAGE</th>
                                <th scope="col">DATE CREATED</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($announcementInfoArray)): ?>
                                <tr>
                                    <td colspan="6" style="color:#D2042D; font-weight: bold; text-align: center;">NO ANNOUNCEMENT FOUND</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($announcementInfoArray as $a): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($a['announcementID']) ?></td>
                                        <td><?= htmlspecialchars($a['title']) ?></td>
                                        <td><?= htmlspecialchars(substr($a['message'], 0, 100)) ?><?= strlen($a['message']) > 100 ? '...' : '' ?></td>
                                        <td><?= htmlspecialchars($a['dateCreated']) ?></td>
                                        <td class="text-center">
                                            <a data-bs-toggle="modal" data-bs-target="#editAnnouncement<?= $a['announcementID'] ?>Modal"><i class="bi bi-pencil-square px-2"></i></a>
                                            <a data-bs-toggle="modal" data-bs-target="#deleteAnnouncement<?= $a['announcementID'] ?>Modal" style="color:red;"><i class="bi bi-trash3 px-2"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing <?= $startEntry ?> to <?= $endEntry ?> of <?= $totalEntries ?> entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination mt-3">
                        <?php
                        $range = 1;
                        $start = max(1, $currentPage - $range);
                        $end = min($totalPages, $currentPage + $range);
                        ?>

                        <!-- Previous Arrow -->
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?= $currentPage - 1 ?>&entriesCount=<?= $entriesCount ?>&search=<?= $search ?>&sortBy=<?= $sortBy ?>&orderBy=<?= $orderBy ?>"
                                    aria-label="Previous">&laquo;</a>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers -->
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

            <!-- Add, Edit, and Delete Modals -->
            <?php include("../assets/php/modals/admin/announcement.php"); ?>        
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <!-- JavaScript for Modal Actions -->
    <script>
        // ADD Announcement
        document.getElementById('openConfirmAdd').addEventListener('click', function () {
            const title = document.getElementById('newAnnouncementTitle').value.trim();
            const message = document.getElementById('newAnnouncementDescription').value.trim();

            if (title && message) {
                document.getElementById('confirmAddAnnouncementTitle').innerText = title;
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmAddAnnouncementModal'));
                confirmModal.show();
            }
        });

        document.getElementById('confirmAddBtn').addEventListener('click', function () {
            document.getElementById('addAnnouncementForm').submit();
        });

        // EDIT Announcement
        document.querySelectorAll('[data-confirm-edit-btn]').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                document.getElementById(`editAnnouncementForm${id}`).submit();
            });
        });

        // DELETE Announcement
        document.querySelectorAll('[data-confirm-delete-btn]').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                document.getElementById(`deleteAnnouncementForm${id}`).submit();
            });
        });
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const url = new URL(window.location);
            const paramsToRemove = ['added', 'updated', 'deleted', 'highlight'];

            let shouldUpdate = false;

            paramsToRemove.forEach(param => {
            if (url.searchParams.has(param)) {
                url.searchParams.delete(param);
                shouldUpdate = true;
            }
            });

            if (shouldUpdate) {
            window.history.replaceState({}, document.title, url.pathname + '?' + url.searchParams.toString());
            }
        });
    </script>
</body>

</html>