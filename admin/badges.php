<?php
session_start();
if (empty($_SESSION['userID'])) {
    header("Location: ../login.php");
    exit();
} if ($_SESSION['role'] === 'user') {
    header("Location: ../user/index.php"); 
    exit();
}
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
        <div class="container-fluid py-4 px-4">

            <!-- Heading -->
            <div class="col-12 mb-4">
                <div class="heading text-center text-sm-start">BADGES</div>
            </div>

            <div class="d-flex justify-content-end align-items-center mb-3">
                <!-- Add new button -->
                <button class="btn btn-primary subheading" data-bs-toggle="modal" data-bs-target="#addBadgeModal">ADD NEW</button>
            </div>

            <!-- User Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Badge</th>
                                <th scope="col">Description</th>
                                <th scope="col">Value</th>
                                <th scope="col">Icon</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- User Data -->
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Fresh Starter</td>
                                <td>First gym check-in</td>
                                <td>5</td>
                                <td>starter.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>Weekly Warrior</td>
                                <td>Checked in for 5 days straight</td>
                                <td>25</td>
                                <td>weekly.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>Monthly Grinder</td>
                                <td>Checked in for a total of 20 days</td>
                                <td>100</td>
                                <td>monthly.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">4</td>
                                <td>Commitment Champ</td>
                                <td>Checked in for a total of 60 days</td>
                                <td>300</td>
                                <td>3months.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">5</td>
                                <td>Half-year Beast</td>
                                <td>Checked in for a total of 120 days</td>
                                <td>600</td>
                                <td>6month.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                             <tr>
                                <td scope="row">5</td>
                                <td>Wourkout Master</td>
                                <td>Checked in for a total of 200 days</td>
                                <td>1000</td>
                                <td>master.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                             <tr>
                                <td scope="row">5</td>
                                <td>Loyalty Legend</td>
                                <td>Checked in for a total of 240 days</td>
                                <td>1200</td>
                                <td>loyalty.png</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editBadges1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Badges Modal -->
            <div class="modal fade" id="editBadges1Modal" tabindex="-1"
                aria-labelledby="editBadges1ModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="editBadges1ModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                EDIT BADGES
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body" style="padding: 1.5rem;">
                            <form id="editBadgesForm">
                                <div class="mb-3 text-start">
                                    <label for="badgeName" class="form-label fw-bold">Badge</label>
                                    <input type="text" class="form-control" id="badgeName" value="Fresh Starter">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="badgeDescription" class="form-label fw-bold">Description</label>
                                    <input type="text" class="form-control" id="badgeDescription" value="First gym check-in">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="badgeType" class="form-label fw-bold">Type</label>
                                    <input type="text" class="form-control" id="badgeType" value="Attendance">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="badgeValue" class="form-label fw-bold">Value</label>
                                    <input type="text" class="form-control" id="badgeValue" value="1">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="badgeIcon" class="form-label fw-bold">Icon</label>
                                    <input type="file" class="form-control" id="badgeIcon" accept="image/*">
                                </div>
                            </form>
                        </div>


                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmEditBadges1Modal">
                                SAVE CHANGES
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Edit Badge Modal -->
            <div class="modal fade" id="confirmEditBadges1Modal" tabindex="-1"
                aria-labelledby="confirmEditBadgeLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmEditBadgeLabel" style="margin: 0;">
                                BADGE UPDATED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            Badge has been successfully edited.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add New Membership Plan Modal -->
            <div class="modal fade" id="addBadgeModal" tabindex="-1"
                aria-labelledby="addBadgeModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="addBadgeModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                ADD NEW BADGE
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body" style="padding: 1.5rem;">
                            <form id="addBadgeForm">
                                <div class="mb-3 text-start">
                                    <label for="planType" class="form-label fw-bold">Badge</label>
                                    <input type="text" class="form-control" id="planType">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="requirement" class="form-label fw-bold">Description</label>
                                    <input type="text" class="form-control" id="requirement">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="price" class="form-label fw-bold">Type</label>
                                    <input type="text" class="form-control" id="price">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="price" class="form-label fw-bold">Value</label>
                                    <input type="text" class="form-control" id="price">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="badgeIcon" class="form-label fw-bold">Icon</label>
                                    <input type="file" class="form-control" id="badgeIcon" accept="image/*">
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmaddBadgeModal">
                                ADD
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Add Badge Modal -->
            <div class="modal fade" id="confirmaddBadgeModal" tabindex="-1"
                aria-labelledby="confirmaddBadgeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmaddBadgeModalLabel" style="margin: 0;">
                                BADGE ADDED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            New badge has been successfully added.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Badge Modal -->
            <div class="modal fade" id="deleteBadge1Modal" tabindex="-1"
                aria-labelledby="deleteBadge1ModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="deleteBadge1ModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                DELETE BADGE
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body text-center" style="padding: 1.5rem;">
                            <p style="margin: 0; font-size: 16px; color: black;">
                                Are you sure you want to delete this badge?
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmDeleteBadge1Modal"
                                data-bs-dismiss="modal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Delete Badge Modal -->
            <div class="modal fade" id="confirmDeleteBadge1Modal" tabindex="-1"
                aria-labelledby="confirmDeleteMembershipModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmDeleteMembershipModalLabel" style="margin: 0;">
                                BADGE DELETED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            Badge has been successfully deleted.
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
                    Showing 2 of 3 entries
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
            <!-- MARK -->
            <div class="col-12 mt-4">
                <div class="heading text-center text-sm-start">USER BADGES</div>
            </div>

            <!-- Controls: Search, Sort By, Order By, Apply Button -->
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">

                <!-- Search -->
                <div class="flex-grow-1 flex-sm-grow-0 input-group" style="min-width: 220px; max-width: 300px;">
                    <input type="search" id="searchInput" class="form-control" placeholder="Search users...">
                    <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>

                <!-- Sort By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 160px; max-width: 220px;">
                    <select id="sortBy" class="form-select">
                        <option selected disabled>Sort By</option>
                        <option value="first_name">ID</option>
                        <option value="last_name">Badge_ID</option>
                        <option value="last_name">Date Earned</option>
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
            </div>

            <!-- Second Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Badge_ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Date Earned</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>1</td>
                                <td>Jenna Miles Reyes</td>
                                <td>2025-05-18</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteUserBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>2025-05-18</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteUserBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>1</td>
                                <td>Jane Air</td>
                                <td>2025-05-18</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteUserBadge1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delete User Badge Modal -->
            <div class="modal fade" id="deleteUserBadge1Modal" tabindex="-1"
                aria-labelledby="deleteUserBadge1ModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="deleteUserBadge1ModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                DELETE USER BADGE
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body text-center" style="padding: 1.5rem;">
                            <p style="margin: 0; font-size: 16px; color: black;">
                                Are you sure you want to delete this user badge?
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmDeleteUserBadge1Modal"
                                data-bs-dismiss="modal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Delete User Badge Modal -->
            <div class="modal fade" id="confirmDeleteUserBadge1Modal" tabindex="-1"
                aria-labelledby="confirmDeleteUserBadgeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmDeleteUserBadgeModalLabel" style="margin: 0;">
                                USER BADGE DELETED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            User badge has been successfully deleted.
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
                    Showing 2 of 3 entries
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