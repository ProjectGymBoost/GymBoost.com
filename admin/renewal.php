<?php
include("../assets/shared/connect.php");
include("../assets/php/classes/classes.php");

session_start();
include("../assets/shared/auth.php");
include("../assets/php/processes/admin/renewal.php"); // Form POST logic


// Fetch user list for dropdown
$usersQuery = "SELECT u.userID, u.firstName, u.lastName FROM users u WHERE u.role = 'user' ORDER BY u.firstName ASC";
$usersResult = mysqli_query($conn, $usersQuery);

$membershipQuery = "SELECT * FROM memberships";
$membershipResult = mysqli_query($conn, $membershipQuery);
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | Renewal Membership</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />

    <style>
    /* Match Bootstrap 5 form-select style */
    .select2-container--default .select2-selection--single {
        height: calc(2.375rem + 2px); 
        padding: 0.375rem 0.25rem;
        font-size: 1rem;
        line-height: 1.5;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    /* Fix the arrow to match position */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 5px;
    }

    /* Remove extra spacing below */
    .select2-container {
        width: 100% !important;
    }
    </style>
</head>

<body>
    <form method="POST">
        <?php include('../assets/shared/sidebar.php'); ?>

        <div class="main px-2 px-md-0" style="margin-left: 70px;">
            <div class="container-fluid py-3 px-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8 mb-4">
                        <div class="heading text-center">RENEW MEMBERSHIP</div>

                        <?php if (isset($_GET['active']) && $_GET['active'] == 1): ?>
                            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                                    aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            Renewal failed. User is still <strong>Active</strong>.
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <script>
                                const url = new URL(window.location);
                                url.searchParams.delete('active');
                                history.replaceState(null, '', url.toString());
                            </script>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-center align">
                        <div class="d-flex flex-column align-items-center gap-3 p-3 p-lg-5 card-bg-color"
                            style="width: 100%; max-width: 800px; border-radius: 10px;">

                            <!-- User Dropdown -->
                            <div class="w-100 mb-3">
                                <label class="form-label fw-bold">Select User</label>
                                <select class="form-select select2" name="userID" required>
                                    <?php if (mysqli_num_rows($usersResult) > 0): ?>
                                        <?php while ($user = mysqli_fetch_assoc($usersResult)): ?>
                                            <option value="<?= $user['userID']; ?>">
                                                <?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <option disabled selected>No active users available</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Membership Plan -->
                            <div class="w-100 mb-3">
                                <label class="form-label fw-bold">Membership Plan</label>
                                <select class="form-select" name="membershipID" id="membershipPlan" required>
                                    <?php while ($plan = mysqli_fetch_assoc($membershipResult)): ?>
                                        <option value="<?= $plan['membershipID']; ?>"
                                            data-requirement="<?= $plan['requirement']; ?>">
                                            <?= htmlspecialchars($plan['planType']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Start & End Date -->
                            <div class="w-100 mb-3">
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Start Date</label>
                                        <input type="date" class="form-control" name="startDate" id="startDate" min="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">End Date</label>
                                        <input type="date" class="form-control" name="endDate" id="endDate" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Renew Button and Cancel Button -->
                            <div class="w-100 text-center mt-3">
                                <button type="submit" name="btnRenew" class="btn btn-primary mt-2">RENEW MEMBERSHIP</button>
                                <a class="btn btn-secondary mt-2" href="membership.php">CANCEL</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- JS to auto-calculate endDate -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Enable Select2
                $('.select2').select2({
                    placeholder: 'Select User',
                    width: '100%'
                });

                const planSelect = document.getElementById('membershipPlan');
                const startInput = document.getElementById('startDate');
                const endInput = document.getElementById('endDate');

                // Add error containers under date inputs (if not already in HTML)
                if (!document.getElementById('startDateError')) {
                    const div = document.createElement('div');
                    div.id = 'startDateError';
                    div.className = 'invalid-feedback text-start';
                    startInput.insertAdjacentElement('afterend', div);
                }
                if (!document.getElementById('endDateError')) {
                    const div = document.createElement('div');
                    div.id = 'endDateError';
                    div.className = 'invalid-feedback text-start';
                    endInput.insertAdjacentElement('afterend', div);
                }

                const startError = document.getElementById('startDateError');
                const endError = document.getElementById('endDateError');

                // Auto-update end date based on plan duration
                function updateEndDate() {
                    const selectedOption = planSelect.options[planSelect.selectedIndex];
                    const requirement = selectedOption.getAttribute('data-requirement');
                    const match = requirement ? requirement.match(/(\d+)\s*days?/i) : null;
                    if (!match) return;

                    const days = parseInt(match[1], 10);
                    const startDate = new Date(startInput.value);
                    if (isNaN(startDate.getTime())) return;

                    const endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + days);

                    const yyyy = endDate.getFullYear();
                    const mm = String(endDate.getMonth() + 1).padStart(2, '0');
                    const dd = String(endDate.getDate()).padStart(2, '0');
                    endInput.value = `${yyyy}-${mm}-${dd}`;
                }

                // Validate date logic
                function validateDates() {
                    let valid = true;
                    startError.textContent = '';
                    endError.textContent = '';

                    const startVal = startInput.value;
                    const endVal = endInput.value;

                    if (!startVal || !endVal) return true;

                    const startDate = new Date(startVal);
                    const endDate = new Date(endVal);

                    const today = new Date();
                    const maxEnd = new Date();
                    maxEnd.setFullYear(maxEnd.getFullYear() + 5);

                    if ($startDate < date('Y-m-d')) {
                        startError.textContent = 'Start date cannot be in the past.';
                        valid = false;
                    }
                    if (endDate <= startDate) {
                        endError.textContent = 'End date must be after start date.';
                        valid = false;
                    }
                    if (endDate > maxEnd) {
                        endError.textContent = 'End date is too far in the future.';
                        valid = false;
                    }

                    return valid;
                }

                // Event bindings
                planSelect.addEventListener('change', () => {
                    updateEndDate();
                    validateDates();
                });
                startInput.addEventListener('change', () => {
                    updateEndDate();
                    validateDates();
                });
                endInput.addEventListener('change', validateDates);

                // Prevent bad submission
                const form = startInput.closest('form');
                form.addEventListener('submit', function (e) {
                    if (!validateDates()) {
                        e.preventDefault();
                        startInput.classList.add('is-invalid');
                        endInput.classList.add('is-invalid');
                    } else {
                        startInput.classList.remove('is-invalid');
                        endInput.classList.remove('is-invalid');
                    }
                });
            });
        </script>
    </form>
</body>

</html>