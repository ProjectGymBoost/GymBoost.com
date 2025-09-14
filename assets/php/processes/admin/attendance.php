<?php
include(__DIR__ . '/../user/achievements.php');

// SEARCH
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchSafe = mysqli_real_escape_string($conn, $search);

$searchCondition = '';
if (!empty($searchSafe)) {
    // Split the search into words
    $searchWords = explode(' ', $searchSafe);

    $conditions = [];
    foreach ($searchWords as $word) {
        $wordSafe = mysqli_real_escape_string($conn, $word);

        // Each word can match firstName, lastName, attendanceID, or checkinDate
        $conditions[] = "(users.firstName LIKE '%$wordSafe%' 
                          OR users.lastName LIKE '%$wordSafe%' 
                          OR attendances.attendanceID LIKE '%$wordSafe%' 
                          OR attendances.checkinDate LIKE '%$wordSafe%')";
    }

    // Require all words to match somewhere
    $searchCondition = " AND (" . implode(" AND ", $conditions) . ")";
}

// SORT AND ORDER BY
$sortBy = $_GET['sortBy'] ?? 'attendanceID';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'DESC';

$allowedSortColumns = ['attendanceID', 'firstName', 'lastName', 'checkinDate'];
$allowedOrder = ['ASC', 'DESC'];

if (in_array($sortBy, $allowedSortColumns) && in_array($orderBy, $allowedOrder)) {
    $orderCondition = "ORDER BY $sortBy $orderBy";
} else {
    $orderCondition = "ORDER BY attendances.attendanceID DESC";
}

// PAGINATION
$entriesCount = isset($_GET['entriesCount']) ? (int) $_GET['entriesCount'] : 5;
if (!in_array($entriesCount, [5, 10, 25, 50]))
    $entriesCount = 5;

$currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($currentPage - 1) * $entriesCount;

// TOTAL MATCHING ENTRIES
$totalQuery = "
    SELECT COUNT(*) AS total
    FROM attendances
    JOIN users ON users.userID = attendances.userID
    WHERE users.role = 'user' 
    $searchCondition
";

$totalResult = executeQuery($totalQuery);
$totalEntries = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalEntries / $entriesCount);
$range = 1;
$start = max(1, $currentPage - $range);
$end = min($totalPages, $currentPage + $range);

$startEntry = ($totalEntries > 0) ? $offset + 1 : 0;
$endEntry = ($totalEntries > 0) ? min($offset + $entriesCount, $totalEntries) : 0;

// MAIN DATA QUERY
$userInfoQuery = "
SELECT 
        users.userID,
        users.role,
        users.firstName,
        users.lastName,
        attendances.attendanceID,
        attendances.checkinDate,
        attendances.timeIn
    FROM 
        users
    JOIN 
        attendances ON users.userID = attendances.userID
    WHERE 
        users.role = 'user'
    $searchCondition
    $orderCondition
    LIMIT $entriesCount OFFSET $offset
";

$userInfoArray = [];
$userInfoResult = executeQuery($userInfoQuery);
if (mysqli_num_rows($userInfoResult) > 0) {
    while ($row = mysqli_fetch_assoc($userInfoResult)) {
        $userInfoArray[] = $row;
    }
}

// DELETE ATTENDANCE
if (isset($_POST['btnDelete'])) {
    $deleteAttendanceId = (int) $_POST['deleteAttendanceId'];
    $deleteFirstName = $_POST['deleteFirstName'];
    $deleteLastName = $_POST['deleteLastName'];
    $deleteDate = $_POST['deleteDate'];
    $currentPage = isset($_POST['currentPage']) ? (int)$_POST['currentPage'] : 1;

    // Get the userID before deleting the attendance record
    $getUserIDQuery = "SELECT userID FROM attendances WHERE attendanceID = $deleteAttendanceId";
    $resultUserID = executeQuery($getUserIDQuery);

    if (mysqli_num_rows($resultUserID) > 0) {
        $rowUserID = mysqli_fetch_assoc($resultUserID);
        $userID = $rowUserID['userID'];

        //Delete the attendance record
        $deleteQuery = "DELETE FROM attendances WHERE attendanceID = $deleteAttendanceId";
        executeQuery($deleteQuery);

        checkAndAssignBadges($conn, $userID);

        // Get the current user's points (more efficient to use userID)
        $selectPointsQuery = "SELECT points FROM users WHERE userID = $userID";
        $result = executeQuery($selectPointsQuery);
        $row = mysqli_fetch_assoc($result);
        $currentPoints = (int) $row['points'];

        // Calculate new points
        $newPoints = max(0, $currentPoints - 5);

        // Update the user's points
        $updatePointsQuery = "UPDATE users SET points = $newPoints WHERE userID = $userID";
        executeQuery($updatePointsQuery);
    }
    
    header(
        "Location: " . $_SERVER['PHP_SELF'] .
        "?deleted=1" .
        "&highlight=" . $deleteAttendanceId .
        "&name=" . urlencode($deleteFirstName . ' ' . $deleteLastName) .
        "&page=" . $currentPage .
        "&date=" . $deleteDate .
        "&entriesCount=" . $entriesCount
    );
    exit;
}
?>

