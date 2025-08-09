<?php
session_start();
include('assets/shared/connect.php');
date_default_timezone_set('Asia/Manila');
include("assets/php/processes/checkin.php");

if (isset($_GET["logout"]) && $_GET["logout"] === "true") {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GymBoost</title>
    <link rel="icon" href="assets/img/logo/officialLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body onload="document.getElementById('rfid').focus()">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="text-center" style="width: 100%; max-width: 500px;">
                        <a href="?logout=true">
                            <img src="assets/img/logo/officialLogo.png" alt="GymBoost" width="150">
                        </a>
                        <div class="heading mb-3" style="font-size: 3.5rem">RFID CHECK-IN</div>
                        <form method="POST" autocomplete="off">
                            <input type="text" id="rfid" name="rfid" class="form-control text-center my-4"
                                style="border-color: var(--primaryColor); border-width: 3px; box-shadow:none; font-size: 25px"
                                placeholder="Scan RFID..." autofocus>
                        </form>
                        <?php if ($message): ?>
                            <div id="alertBox" class="alert <?php echo $success ? 'alert-success' : 'alert-danger' ?> mt-4"
                                role="alert">
                                <?php echo $message ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const rfidInput = document.getElementById("rfid");

    setInterval(() => {
        if (document.activeElement !== rfidInput) {
            rfidInput.focus();
        }
    }, 1000);

    setTimeout(() => {
        const alert = document.getElementById("alertBox");
        if (alert) {
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 600);
        }
    }, 8000);
</script>
</html>