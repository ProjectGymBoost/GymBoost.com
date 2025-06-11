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
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">

                <!-- Search -->
                <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 220px; max-width: 300px;">
                    <input type="search" id="searchInput" class="form-control" placeholder="Search users...">
                </div>

                <!-- Sort By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 160px; max-width: 220px;">
                    <select id="sortBy" class="form-select">
                        <option selected disabled>Sort By</option>
                        <option value="first_name">First Name</option>
                        <option value="last_name">Last Name</option>
                    </select>
                </div>

                <!-- Order By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 140px; max-width: 180px;">
                    <select id="orderBy" class="form-select">
                        <option selected disabled>Order</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <!-- Apply Button -->
                <div>
                    <button id="applyBtn" class="btn btn-primary subheading">APPLY</button>
                </div>
            </div>

            <!-- Pagination and Add New Button -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="small text-muted">
                    Show
                    <select id="entriesCount" class="form-select d-inline-block w-auto mx-1 small text-muted">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    entries
                </div>

                <!-- Add New Button -->
                <a href="register.php" class="btn btn-primary subheading">ADD NEW</a>
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

                        <!-- User Data -->
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Jon</td>
                                <td>Doe</td>
                                <td>johndoe@gmail.com</td>
                                <td>User</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser1Modal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>Jenna Miles</td>
                                <td>Reyes</td>
                                <td>atienzajennamiles@gmail.com</td>
                                <td>User</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser1Modal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>John</td>
                                <td>Smith</td>
                                <td>johnsmith@gmail.com</td>
                                <td>Admin</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser1Modal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">4</td>
                                <td>Emily</td>
                                <td>Brown</td>
                                <td>emilybrown@yahoo.com</td>
                                <td>User</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser1Modal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">5</td>
                                <td>Michael</td>
                                <td>Johnson</td>
                                <td>mjohnson@outlook.com</td>
                                <td>User</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser1Modal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">6</td>
                                <td>Sarah</td>
                                <td>Williams</td>
                                <td>sarahwilliams@gmail.com</td>
                                <td>User</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser1Modal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delete Account Modal -->
            <div class="modal fade" id="deleteUser1Modal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="deleteUserModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                DELETE USER ACCOUNT
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body text-center" style="padding: 1.5rem;">
                            <p style="margin: 0; font-size: 16px; color: black;">
                                Are you sure you want to delete <strong>John Doe's</strong> account? <br><br>If you
                                decided to delete this user's account, all data related to it will also be deleted.
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"">
                                CANCEL
                            </button>
                            <button type=" button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmDeleteUser1Modal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Delete Account Modal -->
            <div class="modal fade" id="confirmDeleteUser1Modal" tabindex="-1"
                aria-labelledby="confirmDeleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;  color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmDeleteUserModalLabel" style="margin: 0;">
                                USER DELETED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            <strong>John Doe's</strong> account has been successfully deleted.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Pagination Info -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing 2 of 2 entries
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-3">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
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