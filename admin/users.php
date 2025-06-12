<?php
include("../assets/shared/connect.php");

// RETRIEVE SEARCH, SORT, AND ORDER PARAMETERS
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

// PAGINATION
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total users for pagination
$countQuery = "SELECT COUNT(*) AS total FROM users";
if (!empty($userSearch)) {
    $countQuery .= " WHERE CONCAT(firstName, ' ', lastName) LIKE '%$userSearch%' 
                        OR firstName LIKE '%$userSearch%' 
                        OR lastName LIKE '%$userSearch%' 
                        OR email LIKE '%$userSearch%' 
                        OR role LIKE '%$userSearch%'";
}
$countResult = executeQuery($countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalUsers = (int) $countRow['total'];
$totalPages = ceil($totalUsers / $limit);

// USERS TABLE QUERY
$usersQuery = "SELECT * FROM users";

// Filter users by search keyword
if (!empty($search)) {
    $userSearch = mysqli_real_escape_string($conn, $search);
    $usersQuery .= " WHERE CONCAT(firstName, ' ', lastName) LIKE '%$userSearch%' 
                        OR firstName LIKE '%$userSearch%' 
                        OR lastName LIKE '%$userSearch%' 
                        OR email LIKE '%$userSearch%' 
                        OR role LIKE '%$userSearch%'";
}

// Apply sorting by column (First name / Last name)
if ($sort != '') {
    $usersQuery = $usersQuery . " ORDER BY $sort";

    // Apply sort direction (ASC / DESC)
    if ($order != '') {
        $usersQuery = $usersQuery . " $order";
    }
}

$usersQuery .= " LIMIT $limit OFFSET $offset";
$usersResult = executeQuery($usersQuery);

// DELETE QUERY - Delete User Data
if (isset($_POST['btnDelete'])) {
    $deleteUserId = $_POST['deleteUserId'];
    $deleteFirstName = $_POST['deleteFirstName'];
    $deleteLastName = $_POST['deleteLastName'];

    $deleteQuery = "DELETE FROM users WHERE userID = $deleteUserId";
    executeQuery($deleteQuery);

    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1&name=" . urlencode($deleteFirstName . ' ' . $deleteLastName));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Dashboard</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
</head>

<style>
    .page-item.active .page-link {
        background-color: #28364e;
        border-color: #28364e;
        color: white;
    }
</style>

<body>

    <?php include('../assets/shared/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main px-2 px-md-0" style="margin-left: 70px; transition: margin-left 0.25s ease-in-out;">
        <div class="container-fluid py-4 px-4">

            <!-- Heading -->
            <div class="col-12 mb-4">
                <div class="heading text-center text-sm-start">USERS</div>
            </div>

            <!-- Controls: Search, Sort By, Order By, Apply Button -->
            <form method="get">
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">

                    <!-- Search-BE Functionality -->
                    <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 220px; max-width: 300px;">
                        <input type="search" name="search" id="searchInput" class="form-control"
                            placeholder="Search users..."
                            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    </div>

                    <!-- Sort By-BE Functionality -->
                    <div class=" flex-grow-1 flex-sm-grow-0" style="min-width: 160px; max-width: 220px;">
                        <select id="sort" name="sort" class="form-control">
                            <option <?php if ($sort == '')
                                echo "selected"; ?> value="">Default Sort</option>

                            <option <?php if ($sort == "firstName") {
                                echo "selected";
                            } ?> value="firstName">First Name
                            </option>

                            <option <?php if ($sort == "lastName") {
                                echo "selected";
                            } ?> value="lastName">Last Name
                            </option>
                        </select>
                    </div>

                    <!-- Order By-BE Functionality -->
                    <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 140px; max-width: 180px;">
                        <select id="order" name="order" class="form-control">
                            <option <?php if ($order == '')
                                echo "selected"; ?> value="">Default Order</option>
                            <option <?php if ($order == "ASC") {
                                echo "selected";
                            } ?> value="ASC">Ascending</option>
                            <option <?php if ($order == "DESC") {
                                echo "selected";
                            } ?> value="DESC">Descending</option>
                        </select>
                    </div>

                    <!-- Apply Button -->
                    <div>
                        <button id="applyBtn" class="btn btn-primary subheading">APPLY</button>
                    </div>
                </div>
            </form>

            <!-- Pagination and Add New Button -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Entries Count Dropdown-BE Functionality -->
                <div class="small text-muted">
                    Show
                    <form method="get" id="entriesForm" class="d-inline">
                        <select name="limit" id="entriesCount"
                            class="form-select d-inline-block w-auto mx-1 small text-muted"
                            onchange="document.getElementById('entriesForm').submit()">
                            <option value="5" <?php echo $limit == 5 ? 'selected' : ''; ?>>5</option>
                            <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                        </select>
                        entries
                        <!-- Keep current search in form -->
                        <input type="hidden" name="search" value="<?php echo $search; ?>">
                    </form>
                </div>

                <!-- Add New Button -->
                <a href=" register.php" class="btn btn-primary subheading">ADD NEW</a>
            </div>

            <!-- User Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">FIRST NAME</th>
                                <th scope="col">LAST NAME</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">ROLE</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- BE Data Retrieval - User Data -->
                        <tbody>
                            <?php
                            if (mysqli_num_rows($usersResult) > 0) {
                                while ($userData = mysqli_fetch_assoc($usersResult)) {
                                    ?>
                                    <tr>
                                        <td scope="row">
                                            <?php echo ($userData['userID']); ?>
                                        </td>
                                        <td>
                                            <?php echo ($userData['firstName']); ?>
                                        </td>
                                        <td><?php echo ($userData['lastName']); ?></td>
                                        <td><?php echo ($userData['email']); ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($userData['role']); ?>
                                        </td>
                                        <td>
                                            <li style="display: flex; justify-content: center;">
                                                <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal<?php echo $userData['userID']; ?>">
                                                    <i class="bi bi-trash3 px-1"></i>
                                                </a>
                                            </li>
                                        </td>
                                    </tr>

                                    <!-- Delete Functionality - Delete Account Modal -->
                                    <div class="modal fade" id="deleteUserModal<?php echo $userData['userID']; ?>" tabindex="-1"
                                        aria-labelledby=" deleteUserModalLabel" aria-hidden="true" data-bs-backdrop="static"
                                        data-bs-keyboard="false">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="border-radius: 15px;">
                                                <!-- Header -->
                                                <div
                                                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                                                    <h4 class="modal-title text-center subheading" id="deleteUserModalLabel"
                                                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                                        DELETE USER ACCOUNT
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"
                                                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body text-center" style="padding: 1.5rem;">
                                                    <p style="margin: 0; font-size: 16px; color: black;">
                                                        Are you sure you want to delete
                                                        <?php echo '<span style="color: #D2042D; font-weight: bold;">' . strtoupper($userData['firstName'] . ' ' . $userData['lastName'] . "'s") . '</span>'; ?>
                                                        account? <br><br>If you
                                                        decided to delete this user's account, all data related to it will also
                                                        be deleted.
                                                    </p>
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer d-flex justify-content-end"
                                                    style="border: none; padding: 1rem;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        CANCEL
                                                    </button>
                                                    <!-- Delete-BE Functionality-->
                                                    <form method="post">
                                                        <input type="hidden" name="deleteUserId"
                                                            value="<?php echo $userData['userID']; ?>">
                                                        <input type="hidden" name="deleteFirstName"
                                                            value="<?php echo $userData['firstName']; ?>">
                                                        <input type="hidden" name="deleteLastName"
                                                            value="<?php echo $userData['lastName']; ?>">
                                                        <button type="submit" class="btn btn-primary" name="btnDelete"
                                                            style="margin-left: 0.5rem;">
                                                            DELETE
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delete-BE Functionality - Delete Confirmation Modal -->
            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1' && isset($_GET['name'])): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteUserModal'));
                        confirmModal.show();
                    });
                </script>
            <?php endif; ?>

            <div class="modal fade" id="confirmDeleteUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <div class="modal-header border-0">
                            <h4 class="modal-title heading text-center w-100 text-black">USER DELETED</h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            <strong>
                                <span style="color: #D2042D; font-weight: bold;">
                                    <?php echo strtoupper($_GET['name']) . "'s"; ?>
                                </span>
                            </strong>
                            account has been successfully deleted.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination-BE Functionality - Bottom Pagination Info -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing <?php echo min($offset + 1, $totalUsers); ?> to
                    <?php echo min($offset + $limit, $totalUsers); ?> of
                    <?php echo $totalUsers; ?> entries
                </div>

                <nav aria-label="Page navigation">
                    <ul class="pagination mt-3">
                        <!-- Previous Button -->
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link"
                                href="<?php echo '?page=' . ($page - 1) . '&limit=' . $limit . '&search=' . urlencode($search); ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                <a class="page-link"
                                    href="<?php echo '?page=' . $i . '&limit=' . $limit . '&search=' . urlencode($search); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">>
                            <a class="page-link"
                                href="<?php echo '?page=' . ($page + 1) . '&limit=' . $limit . '&search=' . urlencode($search); ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>