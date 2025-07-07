<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GymBoost</title>
    <link rel="icon" href="assets/img/logo/officialLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="text-center">
                        <a href="login.php">
                            <img src="assets/img/logo/officialLogo.png" alt="GymBoost" width="120" class="mb-4">
                        </a>
                        <div class="heading my-3">RFID CHECK-IN</div>
                        <form method="POST" autocomplete="off">
                            <input type="text" id="rfid" name="rfid" class="form-control text-center"
                                placeholder="Scan RFID..." autofocus>
                        </form>
                        <div id="alertBox" class="alert alert-danger mt-4" role="alert">
                            RFID not registered. Please contact staff for assistance.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>