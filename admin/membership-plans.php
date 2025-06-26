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

            <!-- Controls: Sort By, Order By, Apply Button -->
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">

                <!-- Sort By -->
                <div class="flex-grow-1 flex-sm-grow-0" style="min-width: 160px; max-width: 220px;">
                    <select id="sortBy" class="form-select">
                        <option selected disabled>Sort By</option>
                        <option value="first_name">Plan Type</option>
                        <option value="last_name">Requirement</option>
                        <option value="last_name">Price</option>
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

                <!-- Add new button -->
                <button class="btn btn-primary subheading" data-bs-toggle="modal" data-bs-target="#addMembershipModal">ADD NEW</button>
            </div>

            <!-- User Table -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Plan Type</th>
                                <th scope="col">Requirement</th>
                                <th scope="col">Price</th>
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- User Data -->
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Half-month</td>
                                <td>15 day</td>
                                <td>₱350</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editMembershipPlan1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteMembershipPlan1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>1 month</td>
                                <td>30 days</td>
                                <td>₱600</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editMembershipPlan1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteMembershipPlan1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>2 months</td>
                                <td>60 days</td>
                                <td>₱1000</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editMembershipPlan1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteMembershipPlan1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">4</td>
                                <td>3 months</td>
                                <td>90 days</td>
                                <td>₱1500</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editMembershipPlan1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteMembershipPlan1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">5</td>
                                <td>Semi-annual</td>
                                <td>180 days</td>
                                <td>₱2850</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editMembershipPlan1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteMembershipPlan1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">6</td>
                                <td>Annual</td>
                                <td>365 days</td>
                                <td>₱5500</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editMembershipPlan1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteMembershipPlan1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Membership Plan Modal -->
            <div class="modal fade" id="editMembershipPlan1Modal" tabindex="-1"
                aria-labelledby="editMembershipPlan1ModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="editMembershipPlan1ModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                EDIT MEMBERSHIP PLAN
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body" style="padding: 1.5rem;">
                            <form id="editMembershipForm">
                                <div class="mb-3 text-start">
                                    <label for="AttendanceFirstName" class="form-label fw-bold">Plan Type</label>
                                    <input type="text" class="form-control" id="AttendanceFirstName" value="Half-month">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="AttendanceFirstName" class="form-label fw-bold">Requirement</label>
                                    <input type="text" class="form-control" id="AttendanceFirstName" value="15 days">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="AttendanceFirstName" class="form-label fw-bold">Price</label>
                                    <input type="text" class="form-control" id="AttendanceFirstName" value="350">
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmEditMembershipPlan1Modal">
                                SAVE CHANGES
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Edit Membership Plan Modal -->
            <div class="modal fade" id="confirmEditMembershipPlan1Modal" tabindex="-1"
                aria-labelledby="confirmEditMembershipModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmEditMembershipModalLabel" style="margin: 0;">
                                MEMBERSHIP PLAN UPDATED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            Membership Plan has been successfully edited.
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
            <div class="modal fade" id="addMembershipModal" tabindex="-1"
                aria-labelledby="addMembershipModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="addMembershipModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                ADD NEW MEMBERSHIP PLAN
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body" style="padding: 1.5rem;">
                            <form id="addMembershipForm">
                                <div class="mb-3 text-start">
                                    <label for="planType" class="form-label fw-bold">Plan Type</label>
                                    <input type="text" class="form-control" id="planType">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="requirement" class="form-label fw-bold">Requirement</label>
                                    <input type="text" class="form-control" id="requirement">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="price" class="form-label fw-bold">Price</label>
                                    <input type="text" class="form-control" id="price">
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmAddMembershipModal">
                                ADD
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Add Membership Modal -->
            <div class="modal fade" id="confirmAddMembershipModal" tabindex="-1"
                aria-labelledby="confirmAddMembershipModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmAddMembershipModalLabel" style="margin: 0;">
                                MEMBERSHIP PLAN ADDED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                            New membership plan has been successfully added.
                        </div>
                        <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Membership Plan Modal -->
            <div class="modal fade" id="deleteMembershipPlan1Modal" tabindex="-1"
                aria-labelledby="deleteMembershipPlan1ModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <!-- Header -->
                        <div
                            style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                            <h4 class="modal-title text-center subheading" id="deleteMembershipPlan1ModalLabel"
                                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                                DELETE MEMBERSHIP PLAN
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"
                                style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body text-center" style="padding: 1.5rem;">
                            <p style="margin: 0; font-size: 16px; color: black;">
                                Are you sure you want to delete this membership plan?
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                                data-bs-toggle="modal" data-bs-target="#confirmdeleteMembershipPlan1Modal"
                                data-bs-dismiss="modal">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Delete Membership Plan Modal -->
            <div class="modal fade" id="confirmdeleteMembershipPlan1Modal" tabindex="-1"
                aria-labelledby="confirmDeleteMembershipModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                        <div class="modal-header" style="border: none;">
                            <h4 class="modal-title heading text-center w-100 text-black"
                                id="confirmDeleteMembershipModalLabel" style="margin: 0;">
                                MEMBERSHIP PLAN DELETED
                            </h4>
                        </div>
                        <div class="modal-body text-center text-black">
                        Membership plan has been successfully deleted.
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