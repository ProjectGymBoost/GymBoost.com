<?php
$userID = $_SESSION['userID'];
$baseURL = $_SERVER['PHP_SELF'] . "?page=achievements";
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'weekly';

// Check if the user already seen the badge earned
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dismiss_badge_modal'])) {
    $userID = $_SESSION['userID'];
    $today = date('Y-m-d');
    $updateQuery = "UPDATE user_badges SET dismissed = 1 WHERE userID = $userID AND DATE(dateEarned) = '$today'";
    mysqli_query($conn, $updateQuery);

    $_SESSION['showNewBadgeDismissed'] = true;
    $_SESSION['showNewBadge'] = false;

    header("Location: ?page=achievements");
    exit();
}

// Assign badges earned 
if (!isset($_SESSION['badgeShownToday'])) {
    checkAndAssignBadges($conn, $userID);

    $today = date('Y-m-d');
    $query = "SELECT b.badgeID, b.badgeName, b.description, b.iconUrl, ub.dateEarned, ub.dismissed
              FROM user_badges ub
              JOIN badges b ON ub.badgeID = b.badgeID
              WHERE ub.userID = $userID AND DATE(ub.dateEarned) = '$today' AND ub.dismissed = 0
              ORDER BY ub.userBadgeID DESC";
    $result = mysqli_query($conn, $query);

    $newlyEarnedBadges = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $badgeData = array();
        $badgeData['badgeID'] = $row['badgeID'];
        $badgeData['name'] = $row['badgeName'];
        $badgeData['desc'] = $row['description'];
        $badgeData['icon'] = $row['iconUrl'];
        $newlyEarnedBadges[] = $badgeData;
    }

    if (!empty($newlyEarnedBadges)) {
        $_SESSION['newlyEarnedBadges'] = $newlyEarnedBadges;
        $_SESSION['showNewBadge'] = true;
    }

    $_SESSION['badgeShownToday'] = true;
}

$resultArr = fetchBadgesAndEarned($conn, $userID);
$badgesResult = $resultArr[0];
$earnedBadgeIDs = $resultArr[1];

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$validPages = array('dashboard', 'workout', 'achievements', 'profile');
if (!in_array($page, $validPages)) {
    header("Location: ?page=dashboard");
    exit();
}

// Check if user attendance meet badge reqs
function checkAndAssignBadges($conn, $userID)
{
    $newlyEarnedBadges = array();
    $userID = $_SESSION['userID'];

    $checkinResult = mysqli_query($conn, "SELECT COUNT(*) AS totalCheckins FROM attendances WHERE userID = $userID");
    $checkinRow = mysqli_fetch_assoc($checkinResult);
    $totalCheckins = (int) $checkinRow['totalCheckins'];

    $badgesResult = mysqli_query($conn, "SELECT badgeID, badgeName, description, iconUrl, requirementValue FROM badges ORDER BY requirementValue ASC");

    $earnedBadgeIDs = array();
    $earnedBadgesResult = mysqli_query($conn, "SELECT badgeID FROM user_badges WHERE userID = $userID");
    while ($row = mysqli_fetch_assoc($earnedBadgesResult)) {
        $earnedBadgeIDs[] = $row['badgeID'];
    }

    $dateNow = date("Y-m-d");

    while ($badge = mysqli_fetch_assoc($badgesResult)) {
        $badgeID = $badge['badgeID'];
        $requirement = $badge['requirementValue'];

        $isEarned = false;

        if ($badgeID == 2) {
            $hasStreak = hasConsecutiveCheckins($conn, $userID, 5);

            if ($hasStreak && !in_array($badgeID, $earnedBadgeIDs)) {
                mysqli_query($conn, "INSERT INTO user_badges (userID, badgeID, dateEarned) VALUES ($userID, $badgeID, '$dateNow')");
                $badgeData = array();
                $badgeData['name'] = $badge['badgeName'];
                $badgeData['desc'] = $badge['description'];
                $badgeData['icon'] = $badge['iconUrl'];
                $newlyEarnedBadges[] = $badgeData;
            } elseif (!$hasStreak && in_array($badgeID, $earnedBadgeIDs)) {
                mysqli_query($conn, "DELETE FROM user_badges WHERE userID = $userID AND badgeID = $badgeID");
            }

        } else {
            if ($totalCheckins >= $requirement && !in_array($badgeID, $earnedBadgeIDs)) {
                mysqli_query($conn, "INSERT INTO user_badges (userID, badgeID, dateEarned) VALUES ($userID, $badgeID, '$dateNow')");
                $badgeData = array();
                $badgeData['name'] = $badge['badgeName'];
                $badgeData['desc'] = $badge['description'];
                $badgeData['icon'] = $badge['iconUrl'];
                $newlyEarnedBadges[] = $badgeData;
            } elseif ($totalCheckins < $requirement && in_array($badgeID, $earnedBadgeIDs)) {
                mysqli_query($conn, "DELETE FROM user_badges WHERE userID = $userID AND badgeID = $badgeID");
            }
        }
    }

    return $newlyEarnedBadges;
}

// For consecutive checkins
function hasConsecutiveCheckins($conn, $userID, $requiredDays)
{
    $countCheckinQuery = "SELECT DATE(checkinDate) as checkinDate FROM attendances 
              WHERE userID = $userID 
              GROUP BY DATE(checkinDate) 
              ORDER BY checkinDate ASC";

    $countCheckinResult = executeQuery($countCheckinQuery);
    $dates = [];

    while ($row = mysqli_fetch_assoc($countCheckinResult)) {
        $dates[] = $row['checkinDate'];
    }

    $count = 1;
    for ($i = 1; $i < count($dates); $i++) {
        $prevDate = new DateTime($dates[$i - 1]);
        $currentDate = new DateTime($dates[$i]);
        $diff = $prevDate->diff($currentDate)->days;

        if ($diff === 1) {
            $count++;
            if ($count >= $requiredDays) {
                return true;
            }
        } else {
            $count = 1;
        }
    }

    return false;
}

// Fetch badge earned by user
function fetchBadgesAndEarned($conn, $userID)
{
    $badgesResult = mysqli_query($conn, "SELECT * FROM badges ORDER BY requirementValue ASC");
    $earnedBadgesResult = mysqli_query($conn, "SELECT badgeID FROM user_badges WHERE userID = $userID");
    $earnedBadgeIDs = [];
    while ($row = mysqli_fetch_assoc($earnedBadgesResult)) {
        $earnedBadgeIDs[] = $row['badgeID'];
    }

    return [$badgesResult, $earnedBadgeIDs];
}

// FETCH LEADERBOARD DATA
$filter = $_GET['filter'] ?? 'all';

$leaderboardQuery = '';

if ($filter === 'weekly') {
    $leaderboardQuery = "
        WITH pointsPerUser AS (
            SELECT attendances.userID, COUNT(*) * 5 AS points
            FROM attendances
            JOIN users ON users.userID = attendances.userID
            WHERE YEARWEEK(attendances.checkinDate, 0) = YEARWEEK(CURDATE(), 0)
              AND users.role = 'user'
              AND users.state = 'active'
            GROUP BY attendances.userID
        ),
        rankedUsers AS (
            SELECT pointsPerUser.userID,
                   CONCAT(users.firstName, ' ', users.lastName) AS username,
                   pointsPerUser.points,
                   DENSE_RANK() OVER (ORDER BY pointsPerUser.points DESC) AS rank
            FROM pointsPerUser
            JOIN users ON users.userID = pointsPerUser.userID
        )
        SELECT *
        FROM rankedUsers
        WHERE rank <= 5
        ORDER BY points DESC, username ASC
    ";
} elseif ($filter === 'monthly') {
    $leaderboardQuery = "
        WITH pointsPerUser AS (
            SELECT attendances.userID, COUNT(*) * 5 AS points
            FROM attendances
            JOIN users ON users.userID = attendances.userID
            WHERE DATE_FORMAT(attendances.checkinDate, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
              AND users.role = 'user'
              AND users.state = 'active'
            GROUP BY attendances.userID
        ),
        rankedUsers AS (
            SELECT pointsPerUser.userID,
                   CONCAT(users.firstName, ' ', users.lastName) AS username,
                   pointsPerUser.points,
                   DENSE_RANK() OVER (ORDER BY pointsPerUser.points DESC) AS rank
            FROM pointsPerUser
            JOIN users ON users.userID = pointsPerUser.userID
        )
        SELECT *
        FROM rankedUsers
        WHERE rank <= 5
        ORDER BY points DESC, username ASC
    ";
} else {
    $leaderboardQuery = "
        WITH pointsPerUser AS (
            SELECT users.userID, users.points
            FROM users
            WHERE users.role = 'user'
              AND users.state = 'active'
              AND users.points > 0
        ),
        rankedUsers AS (
            SELECT pointsPerUser.userID,
                   CONCAT(users.firstName, ' ', users.lastName) AS username,
                   pointsPerUser.points,
                   DENSE_RANK() OVER (ORDER BY pointsPerUser.points DESC) AS rank
            FROM pointsPerUser
            JOIN users ON users.userID = pointsPerUser.userID
        )
        SELECT *
        FROM rankedUsers
        WHERE rank <= 5
        ORDER BY points DESC, username ASC
    ";
}

// EXECUTE LEADERBOARD QUERY
$leaderboard = [];
$yourRank = null;
$yourPoints = 0;

$result = executeQuery($leaderboardQuery);
$hasLeaderboardData = (mysqli_num_rows($result) > 0);

if ($hasLeaderboardData) {
    while ($userRow = mysqli_fetch_assoc($result)) {
        if ((int) $userRow['userID'] === (int) $userID) {
            $yourRank = $userRow['rank'];
            $yourPoints = $userRow['points'];
        }
        $leaderboard[] = $userRow;
    }
}

// DISPLAY THE CURRENT RANK OF THE LOGGED-IN USER
$userRankQuery = '';

if ($filter === 'weekly') {
    $userRankQuery = "
        SELECT rank, points FROM (
            SELECT userID, points, DENSE_RANK() OVER (ORDER BY points DESC) AS rank
            FROM (
                SELECT attendances.userID, COUNT(*) * 5 AS points
                FROM attendances
                JOIN users ON users.userID = attendances.userID
                WHERE YEARWEEK(attendances.checkinDate, 0) = YEARWEEK(CURDATE(), 0)
                  AND users.role = 'user'
                  AND users.state = 'active'
                GROUP BY attendances.userID
            ) AS rankedPoints
        ) AS rankedUsers
        WHERE userID = $userID
    ";
} elseif ($filter === 'monthly') {
    $userRankQuery = "
        SELECT rank, points FROM (
            SELECT userID, points, DENSE_RANK() OVER (ORDER BY points DESC) AS rank
            FROM (
                SELECT attendances.userID, COUNT(*) * 5 AS points
                FROM attendances
                JOIN users ON users.userID = attendances.userID
                WHERE DATE_FORMAT(attendances.checkinDate, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
                  AND users.role = 'user'
                  AND users.state = 'active'
                GROUP BY attendances.userID
            ) AS rankedPoints
        ) AS rankedUsers
        WHERE userID = $userID
    ";
} else {
    $userRankQuery = "
        SELECT rank, points FROM (
            SELECT userID, points, DENSE_RANK() OVER (ORDER BY points DESC) AS rank
            FROM users
            WHERE role = 'user'
              AND state = 'active'
              AND points > 0
        ) AS rankedUsers
        WHERE userID = $userID
    ";
}

$userRankResult = executeQuery($userRankQuery);

if ($hasLeaderboardData && mysqli_num_rows($userRankResult) > 0) {
    $userRankData = mysqli_fetch_assoc($userRankResult);
    $yourPoints = $userRankData['points'];

    if ((int) $yourPoints > 0 && (int) $userRankData['rank'] <= 50) {
        $yourRank = $userRankData['rank'];
    } else {
        $yourRank = 'N/A';
    }
} else {
    $yourRank = null;
    $yourPoints = 0;
}

