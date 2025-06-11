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
                <div class="heading text-center text-sm-start">REWARDS</div>
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
                <div>
                    <a class="btn btn-primary subheading" data-bs-toggle="modal" data-bs-target="#addRewardsModal">ADD
                        NEW</a>
                </div>

                <!-- Add Reward Modal -->
                <div class="modal fade" id="addRewardsModal" tabindex="-1" aria-labelledby="addRewardsModalLabel"
                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <!-- Header -->
                            <div
                                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                                <h4 class="modal-title text-center subheading" id="addRewardsModalLabel"
                                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                    ADD NEW REWARD
                                </h4>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"
                                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body" style="padding: 1.5rem;">
                                <form id="addRewardsForm">
                                    <div class="mb-3 text-start">
                                        <label for="RewardName" class="form-label fw-bold">Reward</label>
                                        <input type="text" class="form-control" id="AddRewardName" value="">
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label for="RequirementType" class="form-label fw-bold">Requirement</label>
                                        <input type="text" class="form-control" id="AddRequirementType" value="">
                                    </div>
                                </form>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    CANCEL
                                </button>
                                <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                    data-bs-toggle="modal" data-bs-target="#confirmAddRewardsModal">
                                    SAVE CHANGES
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirm Add Attendance Modal -->
                <div class="modal fade" id="confirmAddRewardsModal" tabindex="-1"
                    aria-labelledby="confirmAddRewardsLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                            <div class="modal-header" style="border: none;">
                                <h4 class="modal-title heading text-center w-100 text-black"
                                    id="confirmAddRewardsModalLabel" style="margin: 0;">
                                    REWARD ADDED
                                </h4>
                            </div>
                            <div class="modal-body text-center text-black">
                                This reward has been successfully added.
                            </div>
                            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                    CLOSE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- User Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">REWARD</th>
                                <th scope="col">REQUIREMENT</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- User Data -->
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Free Hand Grip</td>
                                <td> 2 Months</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editRewardsModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>Free Waist Support/Shaker/Tumbler</td>
                                <td>4 Months</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editRewardsModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>Free Weightlifting Support/Shaker/Tumbler plus amino</td>
                                <td>6 Months</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editRewardsModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">4</td>
                                <td>Free 1 Month plus Sando/Shaker/Tumbler</td>
                                <td>8 Months</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editRewardsModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">5</td>
                                <td>Free 3 Portein Powder Jar</td>
                                <td>10 Months</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editRewardsModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Reward Modal -->
            <div class="modal fade" id="editRewardsModal" tabindex="-1" aria-labelledby="editRewardsModalLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="editRewardsModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                EDIT REWARD
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body" style="padding: 1.5rem;">
                            <form id="editRewardsForm">
                                <div class="mb-3 text-start">
                                    <label for="RewardName" class="form-label fw-bold">Reward</label>
                                    <input type="text" class="form-control" id="EditRewardName" value="Free Hand Grip">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="RequirementType" class="form-label fw-bold">Requirement</label>
                                    <input type="text" class="form-control" id="EditRequirementType" value="2 Months">
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmEditRewardsModal">
                                SAVE CHANGES
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Edit Reward Modal -->
            <div class="modal fade" id="confirmEditRewardsModal" tabindex="-1" aria-labelledby="confirmEditRewardsLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmEditRewardsModalLabel" style="margin: 0;">
                                REWARD UPDATED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            This reward has been successfully edited.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Reward Modal -->
            <div class="modal fade" id="deleteRewardsModal" tabindex="-1" aria-labelledby="deleteRewardsModalLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="deleteRewardsModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                DELETE REWARD
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body text-center" style="padding: 1.5rem;">
                            <p style="margin: 0; font-size: 16px; color: black;">
                                Are you sure you want to delete this reward? <br><br>If you
                                decided to delete this reward, all data related to it will also be deleted.
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmdeleteRewardsModal"
                                data-bs-dismiss="modal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Delete Rewards Modal -->
            <div class="modal fade" id="confirmdeleteRewardsModal" tabindex="-1"
                aria-labelledby="confirmDeleteRewardsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmDeleteRewardsModalLabel" style="margin: 0;">
                                REWARD DELETED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            This reward has been successfully deleted.
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

            <!-- Heading -->
            <div class="col-12 mt-4">
                <div class="heading text-center text-sm-start">USER REWARDS</div>
            </div>

            <!-- Pagination and Add New Button (Second Block) -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <div class="small text-muted">
                    Show
                    <select id="entriesCountExpired" class="form-select d-inline-block w-auto mx-1 small text-muted">
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
                                <th scope="col">REWARD_ID</th>
                                <th scope="col">USERNAME</th>
                                <th scope="col">CLAIMED DATE</th>
                                <th scope="col">STATUS</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>2025-04-03</td>
                                <td>Claimed</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editUserRewardModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">2</td>
                                <td>1</td>
                                <td>Jenna Miles Reyes</td>
                                <td>2025-05-18</td>
                                <td>Claimed</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editUserRewardModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">3</td>
                                <td>1</td>
                                <td>Loreen Marajas</td>
                                <td>2025-10-15</td>
                                <td>Claimed</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editUserRewardModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">4</td>
                                <td>1</td>
                                <td>Lira Torralba</td>
                                <td>2025-01-28</td>
                                <td>Claimed</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editUserRewardModal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserRewardsModal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit User Rewards Modal -->
            <div class="modal fade" id="editUserRewardModal" tabindex="-1"
                aria-labelledby="editRewardModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="editRewardModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                EDIT USER REWARD
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body" style="padding: 1.5rem;">
                            <form id="editRewardForm">
                                <!-- Reward ID -->
                                <div class="mb-3 text-start">
                                    <label class="form-label fw-bold">Reward ID</label>
                                    <div class="form-control-plaintext">1</div>
                                </div>
                                <!-- Username -->
                                <div class="mb-3 text-start">
                                    <label class="form-label fw-bold">Username</label>
                                    <div class="form-control-plaintext">John Doe</div>
                                </div>
                                <!-- Claimed Date -->
                                <div class="mb-3 text-start">
                                    <label for="rewardExpiry" class="form-label fw-bold">Claimed Date</label>
                                    <input type="date" class="form-control" id="rewardExpiry" value="2025-09-25">
                                </div>
                                <!-- Status -->
                                <div class="mb-3 text-start">
                                    <label for="membershipStatus" class="form-label fw-bold">Status</label>
                                    <select class="form-select" id="membershipStatus">
                                        <option value="present">Claimed</option>
                                        <option value="present">Unclaimed</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmEditRewardModal">
                                SAVE CHANGES
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Edit Reward Modal -->
            <div class="modal fade" id="confirmEditRewardModal" tabindex="-1"
                aria-labelledby="confirmEditRewardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmEditRewardModalLabel" style="margin: 0;">
                                REWARD UPDATED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            User reward has been successfully updated.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete User Reward Modal -->
            <div class="modal fade" id="deleteUserRewardsModal" tabindex="-1"
                aria-labelledby="deleteUserRewardsModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="deleteAttendance1ModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                DELETE USER REWARD
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body text-center" style="padding: 1.5rem;">
                            <p style="margin: 0; font-size: 16px; color: black;">
                                Are you sure you want to delete <strong>Jon Doe's</strong> reward? <br><br>If you
                                decided to delete this user's reward, all data related to it will also be deleted.
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmdeleteUserRewardsModal"
                                data-bs-dismiss="modal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Delete User Reward Modal -->
            <div class="modal fade" id="confirmdeleteUserRewardsModal" tabindex="-1"
                aria-labelledby="confirmDeleteUserRewardsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmDeleteUserRewardsModalLabel" style="margin: 0;">
                                USER REWARD DELETED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            This user's reward has been successfully deleted.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Pagination Info -->
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>