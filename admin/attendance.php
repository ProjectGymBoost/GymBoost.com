<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Attendance</title>
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
                <div class="heading text-center text-sm-start">ATTENDANCE</div>
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
                        <option value="last_name">Date</option>
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
                                <th scope="col">DATE</th>
                                <th class="text-center" scope="col">EDIT</th>
                                <th class="text-center" scope="col">DELETE</th>
                            </tr>
                        </thead>

                        <!-- User Data -->
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Jon</td>
                                <td>Doe</td>
                                <td>2025-07-01</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: black; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAttendanceModal">
                                            <i class="bi bi-pencil px-1"></i>
                                        </a>
                                    </li>
                                </td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttendanceModal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>Jenna Miles</td>
                                <td>Reyes</td>
                                <td>2025-07-01</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: black; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAttendanceModal">
                                            <i class="bi bi-pencil px-1"></i>
                                        </a>
                                    </li>
                                </td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttendanceModal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>Jose</td>
                                <td>Rizal</td>
                                <td>2025-07-02</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: black; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAttendanceModal">
                                            <i class="bi bi-pencil px-1"></i>
                                        </a>
                                    </li>
                                </td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttendanceModal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">4</td>
                                <td>Emily</td>
                                <td>Brown</td>
                                <td>2025-07-02</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: black; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAttendanceModal">
                                            <i class="bi bi-pencil px-1"></i>
                                        </a>
                                    </li>
                                </td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttendanceModal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">5</td>
                                <td>Michael</td>
                                <td>Johnson</td>
                                <td>2025-07-03</td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: black; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAttendanceModal">
                                            <i class="bi bi-pencil px-1"></i>
                                        </a>
                                    </li>
                                </td>
                                <td>
                                    <li style="display: flex; justify-content: center;">
                                        <a style="color: red; text-decoration: none;" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttendanceModal">
                                            <i class="bi bi-trash3 px-1"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>