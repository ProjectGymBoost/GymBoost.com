<?php 
// Get RFID input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rfid'])) {
    $rfid = trim($_POST['rfid']);
    $today = date('Y-m-d');
    $rfidSafe = mysqli_real_escape_string($conn, $rfid);

    // Find user by RFID
    $userQuery = "SELECT userID, firstName FROM users WHERE rfidNumber = '$rfidSafe'";
    $userResult = executeQuery($userQuery);

    if (mysqli_num_rows($userResult) > 0) {
        $userRow = mysqli_fetch_assoc($userResult);
        $userID = $userRow['userID'];
        $firstName = $userRow['firstName'];

        // Check membership
        $membershipQuery = "SELECT userMembershipID FROM user_memberships WHERE userID = $userID AND startDate <= '$today' AND endDate >= '$today'";
        $membershipResult = executeQuery($membershipQuery);

        if (mysqli_num_rows($membershipResult) > 0) {
            $membershipRow = mysqli_fetch_assoc($membershipResult);
            $userMembershipID = $membershipRow['userMembershipID'];

            // Check today’s attendance
            $attendanceQuery = "SELECT attendanceID FROM attendances WHERE userID = $userID AND checkinDate = '$today'";
            $attendanceResult = executeQuery($attendanceQuery);

            if (mysqli_num_rows($attendanceResult) == 0) {
                $timeIn = date('h:i A');

                $insertAttendanceQuery = "INSERT INTO attendances (userID, userMembershipID, checkinDate, timeIn) VALUES ('$userID', '$userMembershipID', '$today', '$timeIn')";
                executeQuery($insertAttendanceQuery);

                $updatePointsQuery = "UPDATE users SET points = points + 5 WHERE userID = $userID";
                executeQuery($updatePointsQuery);

                $displayTime = date('h:i A', strtotime($timeIn));
                $_SESSION['message'] = "Welcome, <strong>$firstName</strong>! Check-in successful at <strong>$displayTime</strong>.";
                $_SESSION['success'] = true;
            } else {
                // Already checked in
                $_SESSION['message'] = "<strong>$firstName</strong>, you’ve already checked in today.";
                $_SESSION['success'] = false;
            }
        } else {
            // No valid membership
            $_SESSION['message'] = "<strong>$firstName</strong>, your membership is currently inactive. Please renew or subscribe at the front desk.";
            $_SESSION['success'] = false;
        }
    } else {
        // RFID not found
        $_SESSION['message'] = "<strong>RFID not registered.</strong> Please approach the front desk for assistance.";
        $_SESSION['success'] = false;
    }

    header('Location: ./checkin.php');
    exit();
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$success = isset($_SESSION['success']) ? $_SESSION['success'] : false;
unset($_SESSION['message'], $_SESSION['success']);
?>