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
                <div class="heading text-center text-sm-start">ANNOUNCEMENT</div>
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
                    <a class="btn btn-primary subheading">ADD NEW</a>
                </div>
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
                                <th class="text-center" scope="col">ACTION</th>
                            </tr>
                        </thead>

                        <!-- User Data -->
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Gym Closed</td>
                                <td> April 17-18 (Holiday)</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editAnnouncement1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteAnnouncement1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">2</td>
                                <td>2nd Branch</td>
                                <td> 2nd Branch in Brgy. Sta. Anastacia</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editAnnouncement1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteAnnouncement1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">3</td>
                                <td>New Equipment</td>
                                <td>New Gym Bike Equipment</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editAnnouncement1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteAnnouncement1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
                                        </a>
                                    </li>
                                </td>
                            </tr>

                            <tr>
                                <td scope="row">4</td>
                                <td>Summer Promo</td>
                                <td>20% off on all promos</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#editAnnouncement1Modal">
                                            <i class="bi bi-pencil-square px-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: red;" data-bs-toggle="modal"
                                            data-bs-target="#deleteAnnouncement1Modal">
                                            <i class="bi bi-trash3 px-2"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>