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

        <div id="dashboard" class="container-fluid py-4 px-4">

            <!-- Heading -->
            <div class="col-12 mb-4">
                <div class="heading text-center text-sm-start">DASHBOARD</div>
            </div>

            <div class="container my-4">
                <div class="row g-3">

                    <!-- Users -->
                    <div class="col-md-4">
                        <div class="card-dashboard p-2" style="background-color: var(--secondaryColor); border: none;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="subheading">100</div>
                                    <div>Users</div>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <i class="bi bi-people-fill icon-dashboard" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Members -->
                    <div class="col-md-4">
                        <div class="card-dashboard p-2" style="background-color: var(--secondaryColor); border: none;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="subheading">86</div>
                                    <div>Active Members</div>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <i class="bi bi-person-bounding-box icon-dashboard" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Members -->
                    <div class="col-md-4">
                        <div class="card-dashboard p-2" style="background-color: var(--secondaryColor); border: none;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="subheading">4</div>
                                    <div>New Members</div>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <i class="bi bi-person-plus-fill icon-dashboard" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Today -->
                    <div class="col-md-4">
                        <div class="card-dashboard p-2" style="background-color: var(--secondaryColor); border: none;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="subheading">8</div>
                                    <div>Attendance Today</div>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <i class="bi bi-clipboard-check-fill icon-dashboard" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Rewards -->
                    <div class="col-md-4">
                        <div class="card-dashboard p-2" style="background-color: var(--secondaryColor); border: none;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="subheading">5</div>
                                    <div>Pending Rewards</div>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <i class="bi bi-award-fill icon-dashboard" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Plans -->
                    <div class="col-md-4">
                        <div class="card-dashboard p-2" style="background-color: var(--secondaryColor); border: none;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="subheading">4</div>
                                    <div>Total Plans</div>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <i class="bi bi-journal-bookmark-fill icon-dashboard" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Dashboard Graph for Attendance Report and Member Distribution -->
            <div class="row justify-content-center g-2 m-5">
                <!-- Chart 1 Column -->
                <div class="col-md-6 col-12 d-flex flex-column align-items-center">
                    <div class="subheading text-center mt-3 w-100 p-1 card-title w-100">Attendance Report</div>
                    <div class="card" style="width: 100%; height: 320px;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <canvas id="barChart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 2 Column -->
                <div class="col-md-6 col-12 d-flex flex-column align-items-center">
                    <div class="subheading text-center mt-3 w-100 p-1 card-title">Member Distribution</div>
                    <div class="card" style="width: 100%; height: 320px;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <canvas id="pieChart" style="width: 100%; height: 280px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th colspan="4" class="fw-bold text-center">TOP 10 ACTIVE MEMBERS</th>
                            </tr>
                            <tr>
                                <th scope="col"
                                    style="background-color: var(--secondaryColor) !important; color: var(--text-color-dark) !important; ">
                                    Rank</th>
                                <th scope="col"
                                    style="background-color: var(--secondaryColor) !important; color: var(--text-color-dark) !important; ">
                                    User</th>
                                <th scope="col"
                                    style="background-color: var(--secondaryColor) !important; color: var(--text-color-dark) !important; ">
                                    Workouts this Month</th>
                                <th scope="col"
                                    style="background-color: var(--secondaryColor) !important; color: var(--text-color-dark) !important; ">
                                    Streak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="d-flex align-items-center fw-bold">
                                    <i class="bi bi-award-fill text-warning me-2"></i> 1
                                </td>
                                <td><strong>Jon Doe</strong></td>
                                <td><strong>20</strong></td>
                                <td><strong>12 Days</strong></td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center fw-bold">
                                    <i class="bi bi-award-fill text-primary me-2"></i> 2
                                </td>
                                <td><strong>Jenna Miles</strong></td>
                                <td><strong>18</strong></td>
                                <td><strong>9 Days</strong></td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center fw-bold">
                                    <i class="bi bi-award-fill text-secondary me-2"></i> 3
                                </td>
                                <td><strong>Jose Rizal</strong></td>
                                <td><strong>16</strong></td>
                                <td><strong>6 Days</strong></td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">4</td>
                                <td>Emily Brown</td>
                                <td>14</td>
                                <td>6 Days</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">5</td>
                                <td>Michael Johhnson</td>
                                <td>12</td>
                                <td>6 Days</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">6</td>
                                <td>Sponge Bob</td>
                                <td>11</td>
                                <td>5 Days</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">7</td>
                                <td>Emily Brown</td>
                                <td>10</td>
                                <td>5 Days</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">8</td>
                                <td>Michael Johhnson</td>
                                <td>9</td>
                                <td>5 Days</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">9</td>
                                <td>Sponge Bob</td>
                                <td>8</td>
                                <td>4 Days</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">10</td>
                                <td>Sponge Bob</td>
                                <td>7</td>
                                <td>3 Days</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../assets/js/admin.js"></script>

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