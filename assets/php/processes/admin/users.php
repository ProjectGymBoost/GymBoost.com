<?php
// SEARCH
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$userSearch = !empty($search) ? mysqli_real_escape_string($conn, $search) : '';

$searchCondition = '';

if (!empty($userSearch)) {
    $searchCondition = "AND (
        CONCAT(users.firstName, ' ', users.lastName) LIKE '%$userSearch%' 
        OR users.userID LIKE '%$userSearch%' 
        OR users.firstName LIKE '%$userSearch%' 
        OR users.lastName LIKE '%$userSearch%' 
        OR users.state LIKE '%$userSearch%'
        OR users.points LIKE '%$userSearch%'
    )";
}

// FILTER BY
$filterBy = $_GET['filterBy'] ?? 'none';
$filterCondition = '';
if ($filterBy === 'activeOnly') {
    $filterCondition = "AND users.state = 'active'";
} elseif ($filterBy === 'inactiveOnly') {
    $filterCondition = "AND users.state = 'inactive'";
}

// SORT AND ORDER BY
$sortBy = $_GET['sortBy'] ?? 'none';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = ['firstName', 'lastName', 'points'];
$allowedOrder = ['ASC', 'DESC'];

if (in_array($sortBy, $allowedSortColumns) && in_array($orderBy, $allowedOrder)) {
    $orderCondition = "ORDER BY $sortBy $orderBy";
} else {
    $orderDirection = in_array($orderBy, $allowedOrder) ? $orderBy : 'ASC';
    $orderCondition = "ORDER BY userID $orderDirection";
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
    FROM users
    WHERE role = 'user'
    $filterCondition
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
    SELECT *
    FROM users
    WHERE role = 'user'
    $filterCondition
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
    $deleteUserId = $_POST['deleteUserId'];
    $deleteFirstName = $_POST['deleteFirstName'];
    $deleteLastName = $_POST['deleteLastName'];

    $deleteQuery = "DELETE FROM users WHERE userID = $deleteUserId";
    executeQuery($deleteQuery);

    header(
        "Location: " . $_SERVER['PHP_SELF'] .
        "?deleted=1" .
        "&name=" . urlencode($deleteFirstName . ' ' . $deleteLastName) .
        "&page=" . $currentPage .
        "&entriesCount=" . $entriesCount .
        "&search=" . urlencode($search) .
        "&filterBy=" . urlencode($filterBy) .
        "&sortBy=" . $sortBy .
        "&orderBy=" . $orderBy
    );
    exit;
}