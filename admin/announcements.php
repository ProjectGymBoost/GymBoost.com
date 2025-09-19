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

    <!-- TinyMCE editor -->
    <script src="https://cdn.tiny.cloud/1/4odx9345paodwcigvf36mwf145f25gy8u5o2716stx6wvp4i/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

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

            <!-- Controls Form -->
            <form method="GET" action="" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <!-- Search -->
                <div class="flex-grow-1 input-group" style="max-width: 400px;">
                    <input type="search" name="search" id="searchInput" class="form-control" placeholder="Search announcements..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>

                <!-- Sort By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="max-width: 210px;">
                    <select name="sortBy" class="form-select" onchange="this.form.submit()">
                        <option disabled>Sort By</option>
                        <option value="announcementID" <?= ($sortBy === 'announcementID') ? 'selected' : '' ?>>Announcement ID</option>
                        <option value="title" <?= ($sortBy === 'title') ? 'selected' : '' ?>>Title</option>
                        <option value="message" <?= ($sortBy === 'message') ? 'selected' : '' ?>>Message</option>
                        <option value="dateCreated" <?= ($sortBy === 'dateCreated') ? 'selected' : '' ?>>Date Created</option>
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
                                        <td><?= substr(strip_tags($a['message']), 0, 100) ?><?= strlen($a['message']) > 100 ? '...' : '' ?></td>
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
        document.addEventListener('DOMContentLoaded', function () {
            const url = new URL(window.location);

            // Show Confirm Add modal if needed
            if (url.searchParams.get('added') === '1') {
                new bootstrap.Modal(document.getElementById('confirmAddAnnouncementModal')).show();
            }

            // Remove unwanted params
            const paramsToRemove = ['added', 'updated', 'deleted', 'highlight'];
            let shouldUpdate = false;
            paramsToRemove.forEach(param => {
                if (url.searchParams.has(param)) {
                    url.searchParams.delete(param);
                    shouldUpdate = true;
                }
            });

            if (shouldUpdate) {
                const newUrl = url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : '');
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>


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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Loop through all edit announcement modals
            document.querySelectorAll('[id^="editAnnouncement"]').forEach(modalEl => {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    const form = modalEl.querySelector('form');
                    if (form) {
                        // Reset form fields to their original default values
                        form.reset();

                        // Restore original textareas (optional but safer for announcements)
                        form.querySelectorAll('textarea').forEach(textarea => {
                            textarea.value = textarea.defaultValue;
                        });
                        
                        // Restore original text inputs
                        form.querySelectorAll('input[type="text"]').forEach(input => {
                            input.value = input.defaultValue;
                        });
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Reset and refresh on Add Announcement modal close
            const addModal = document.getElementById('addAnnouncementModal');
            if (addModal) {
                addModal.addEventListener('hidden.bs.modal', function () {
                    const form = addModal.querySelector('form');
                    if (form) {
                        form.reset();
                        // Reset inputs and textareas to their default values, just like edit modals
                        form.querySelectorAll('textarea').forEach(textarea => {
                            textarea.value = textarea.defaultValue;
                        });
                        form.querySelectorAll('input[type="text"]').forEach(input => {
                            input.value = input.defaultValue;
                        });
                    }
                    // Reload the page to discard any partial input or URL params if you want
                    window.location.reload();
                });
            }
        });
    </script>

</body>

</html>