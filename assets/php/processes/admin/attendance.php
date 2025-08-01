<?php

// SEARCH
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$userSearch = !empty($search) ? mysqli_real_escape_string($conn, $search) : '';

$searchCondition = '';

if (!empty($userSearch)) {
    $searchCondition = "AND (
        CONCAT(users.firstName, ' ', users.lastName) LIKE '%$userSearch%' 
        OR attendances.attendanceID LIKE '%$userSearch%' 
        OR users.firstName LIKE '%$userSearch%' 
        OR users.lastName LIKE '%$userSearch%' 
        OR attendances.checkinDate LIKE '%$userSearch%'
    )";
}

// SORT AND ORDER BY
$sortBy = $_GET['sortBy'] ?? 'attendanceID';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = ['attendanceID', 'firstName', 'lastName', 'checkinDate'];
$allowedOrder = ['ASC', 'DESC'];

if (in_array($sortBy, $allowedSortColumns) && in_array($orderBy, $allowedOrder)) {
    $orderCondition = "ORDER BY $sortBy $orderBy";
} else {
    $orderCondition = "ORDER BY attendances.attendanceID ASC";
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

// DELETE QUERY 
if (isset($_POST['btnDelete'])) {
    $deleteAttendanceId = (int) $_POST['deleteAttendanceId'];
    $deleteFirstName = $_POST['deleteFirstName'];
    $deleteLastName = $_POST['deleteLastName'];
    $deleteDate = $_POST['deleteDate'];

    $deleteQuery = "DELETE FROM attendances WHERE attendanceID = $deleteAttendanceId";
    executeQuery($deleteQuery);

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
