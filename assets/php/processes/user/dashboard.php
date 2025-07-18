<?php
$userID = $_SESSION['userID'];

// ANNOUNCEMENTS QUERY
$announcementsQuery = "SELECT * FROM announcements ORDER BY announcementID DESC LIMIT 3";
$announcementsArray = [];
$announcementsResult = executeQuery($announcementsQuery);
if (mysqli_num_rows($announcementsResult) > 0) {
    while ($row = mysqli_fetch_assoc($announcementsResult)) {
        $announcementsArray[] = $row;
    }
}

// USER_MEMBERSHIP QUERY
$usermembershipQuery = "
SELECT user_memberships.membershipID, user_memberships.endDate, memberships.planType
FROM user_memberships
JOIN memberships ON user_memberships.membershipID = memberships.membershipID
WHERE user_memberships.userID = $userID
";
$usermembershipArray = [];
$usermembershipResult = executeQuery($usermembershipQuery);
if (mysqli_num_rows($usermembershipResult) > 0) {
    while ($row = mysqli_fetch_assoc($usermembershipResult)) {
        $usermembershipArray[] = $row;
    }
}

// ATTENDANCE QUERY
$attendanceQuery = "SELECT COUNT(*) AS checkInTotal FROM attendances WHERE userID = $userID";
$attendanceArray = [];
$attendanceResult = executeQuery($attendanceQuery);
if (mysqli_num_rows($attendanceResult) > 0) {
    while ($row = mysqli_fetch_assoc($attendanceResult)) {
        $attendanceArray[] = $row;
    }
}

// POINTS QUERY
$pointsQuery = "SELECT points FROM users WHERE userID = $userID";
$pointsArray = [];
$pointsResult = executeQuery($pointsQuery);
if (mysqli_num_rows($pointsResult) > 0) {
    while ($row = mysqli_fetch_assoc($pointsResult)) {
        $pointsArray[] = $row;
    }
}
?>