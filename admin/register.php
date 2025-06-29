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

        <!-- Heading -->
        <div class="container-fluid py-3 px-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 mb-4">
                    <div class="heading text-center">CREATE ACCOUNT</div>
                </div>

                <!-- Wrapper for horizontal centering -->
                <div class="d-flex justify-content-center align">
                    <div class="d-flex flex-column align-items-center gap-3 p-3 p-lg-5 card-bg-color"
                        style="width: 100%; max-width: 800px; border-radius: 10px;">
                        <div class="d-flex gap-3 w-100">
                            <!-- First Name -->
                            <div class="w-100 mb-2">
                                <input type="text" placeholder="First Name" class="form-control"
                                    style="border-radius: 5px;">
                            </div>

                            <!-- Last Name -->
                            <div class="w-100 mb-2">
                                <input type="text" placeholder="Last Name" class="form-control"
                                    style="border-radius: 5px;">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="w-100 mb-2">
                            <input type="email" placeholder="Email" class="form-control" style="border-radius: 5px;">
                        </div>

                        <!-- Membership Plan -->
                        <select class="form-select">
                            <option selected disabled>Membership Plan</option>
                            <option value="HalfMonth">Half Month</option>
                            <option value="1Month">1 Month</option>
                            <option value="2Months">2 Months</option>
                            <option value="3Months">3 Months</option>
                            <option value="semiannual">Semi Annual</option>
                            <option value="annual">Annual</option>
                        </select>

                        <hr style="border-top: 3px solid var(--primaryColor); opacity: 1; width: 100%; margin: 2rem 0;">

                        <!-- Create Password -->
                        <div class="position-relative w-100 mb-2">
                            <input type="password" id="createPassword" placeholder="Create a Password"
                                class="form-control" style="border-radius: 5px;">
                            <i class="bi bi-eye-slash position-absolute toggle-password" data-target="createPassword"
                                style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor);
     text-shadow: 0 0 1px var(--primaryColor);"></i>
                        </div>

                        <!-- Confirm Password -->
                        <div class="position-relative w-100 mb-2">
                            <input type="password" id="confirmPassword" placeholder="Confirm Password"
                                class="form-control" style="border-radius: 5px;">
                            <i class="bi bi-eye-slash position-absolute toggle-password" data-target="confirmPassword"
                                style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: var(--primaryColor);
     text-shadow: 0 0 1px var(--primaryColor);"></i>
                        </div>

                        <!-- Create Button -->
                        <div class="w-100 text-center mt-3">
                            <button type="submit" class="btn btn-primary">
                                CREATE
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const input = document.getElementById(this.getAttribute('data-target'));
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>

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