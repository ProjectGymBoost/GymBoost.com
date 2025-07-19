<?php
$userID = $_SESSION['userID'];
$baseURL = $_SERVER['PHP_SELF'] . "?page=achievements";
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'weekly';

// FETCH LEADERBOARD DATA
$leaderboardQuery = "";
if ($filter === 'weekly') {
    $leaderboardQuery = "
        SELECT attendances.userID, CONCAT(users.firstName, ' ', users.lastName) AS username, COUNT(*) * 5 AS points
        FROM attendances
        JOIN users ON users.userID = attendances.userID
        WHERE YEARWEEK(attendances.checkinDate, 0) = YEARWEEK(CURDATE(), 0)
        GROUP BY attendances.userID
        ORDER BY points DESC
        LIMIT 5
    ";
} elseif ($filter === 'monthly') {
    $leaderboardQuery = "
        SELECT attendances.userID, CONCAT(users.firstName, ' ', users.lastName) AS username, COUNT(*) * 5 AS points
        FROM attendances
        JOIN users ON users.userID = attendances.userID
        WHERE DATE_FORMAT(attendances.checkinDate, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
        GROUP BY attendances.userID
        ORDER BY points DESC
        LIMIT 5
    ";
} else {
    $leaderboardQuery = "
        SELECT users.userID, CONCAT(users.firstName, ' ', users.lastName) AS username, users.points AS points
        FROM users
        WHERE users.role = 'user'
        ORDER BY users.points DESC
        LIMIT 5
    ";
}


// CALCULATE USER RANKS
$leaderboard = [];
$yourRank = null;
$yourPoints = 0;

$result = executeQuery($leaderboardQuery);

$rank = 1;
$lastRecordedPoints = null;

if (mysqli_num_rows($result) > 0) {
    while ($user = mysqli_fetch_assoc($result)) {
        if ($lastRecordedPoints !== null && $user['points'] < $lastRecordedPoints) {
            $rank++;
        }

        $user['rank'] = $rank;

        if ((int) $user['userID'] === (int) $userID) {
            $yourRank = $rank;
            $yourPoints = $user['points'];
        }

        $leaderboard[] = $user;

        $lastRecordedPoints = $user['points'];
    }
}