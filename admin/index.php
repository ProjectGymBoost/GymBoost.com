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
            <div class="row g-4 mt-4 mb-5">

                <!-- Users -->
                <div class="col-md-4">
                    <div class="card-dashboard p-4" style="background-color: var(--secondaryColor); border: none;">
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
                    <div class="card-dashboard p-4" style="background-color: var(--secondaryColor); border: none;">
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
                    <div class="card-dashboard p-4" style="background-color: var(--secondaryColor); border: none;">
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
                    <div class="card-dashboard p-4" style="background-color: var(--secondaryColor); border: none;">
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
                <!-- <div class="col-md-4">
                    <div class="card-dashboard p-4" style="background-color: var(--secondaryColor); border: none;">
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
                </div> -->

                <!-- Total Plans -->
                <div class="col-md-4">
                    <div class="card-dashboard p-4" style="background-color: var(--secondaryColor); border: none;">
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

            <!-- Dashboard Graph for Attendance Report and Member Distribution -->
            <div class="row">
                <div class="col-auto">
                    <select class="form-select"
                        style="min-width: 150px; background-color: var(--primaryColor); color: var(--text-color-light); background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27white%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M1.5 5.5l6 6 6-6%27/%3E%3C/svg%3E');">
                        <option selected disabled>Select Year</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center g-2 g-md-4 mb-5">
                <!-- Chart 1 Column -->
                <div class="col-lg-4 col-md-6 col-12 d-flex flex-column align-items-center">
                    <div class="subheading text-center mt-3 w-100 p-1 card-title"
                        style="background-color: var(--primaryColor); color: var(--text-color-light);">ATTENDANCE REPORT
                    </div>
                    <div class="card rounded-0" style="width: 100%; height: 320px;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <canvas id="barChart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 2 Column -->
                <div class="col-lg-4 col-md-6 col-12 d-flex flex-column align-items-center">
                    <div class="subheading text-center mt-3 w-100 p-1 card-title"
                        style="background-color: var(--primaryColor); color: var(--text-color-light);">MEMBER
                        DISTRIBUTION</div>
                    <div class="card rounded-0" style="width: 100%; height: 320px;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <canvas id="pieChart" style="width: 100%; height: 280px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 3 Column -->
                <div class="col-lg-4 col-md-6 col-12 d-flex flex-column align-items-center">
                    <div class="subheading text-center mt-3 w-100 p-1 card-title"
                        style="background-color: var(--primaryColor); color: var(--text-color-light);">AGE DEMOGRAPHICS
                    </div>
                    <div class="card rounded-0" style="width: 100%; height: 320px;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <canvas id="doughnutChart" style="width: 100%; height: 280px;"></canvas>
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
                                    Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="d-flex align-items-center fw-bold">
                                    <i class="bi bi-award-fill text-warning me-2"></i> 1
                                </td>
                                <td><strong>Jon Doe</strong></td>
                                <td><strong>20</strong></td>
                                <td><strong>1500</strong></td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center fw-bold">
                                    <i class="bi bi-award-fill text-primary me-2"></i> 2
                                </td>
                                <td><strong>Jenna Miles</strong></td>
                                <td><strong>18</strong></td>
                                <td><strong>1400</strong></td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center fw-bold">
                                    <i class="bi bi-award-fill text-secondary me-2"></i> 3
                                </td>
                                <td><strong>Jose Rizal</strong></td>
                                <td><strong>16</strong></td>
                                <td><strong>1300</strong></td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">4</td>
                                <td>Emily Brown</td>
                                <td>14</td>
                                <td>1200</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">5</td>
                                <td>Michael Johhnson</td>
                                <td>12</td>
                                <td>1100</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">6</td>
                                <td>Sponge Bob</td>
                                <td>11</td>
                                <td>1000</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">7</td>
                                <td>Emily Brown</td>
                                <td>10</td>
                                <td>900</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">8</td>
                                <td>Michael Johhnson</td>
                                <td>9</td>
                                <td>800</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">9</td>
                                <td>Sponge Bob</td>
                                <td>8</td>
                                <td>700</td>
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">10</td>
                                <td>Sponge Bob</td>
                                <td>7</td>
                                <td>600</td>
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
</body>

</html>