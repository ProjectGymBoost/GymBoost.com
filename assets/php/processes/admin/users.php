<?php
// FILTER BY
$filterBy = $_GET['filterBy'] ?? 'none';
$filterCondition = '';

if ($filterBy === 'activeOnly') {
    $filterCondition = "WHERE users.state = 'active'";
} elseif ($filterBy === 'inactiveOnly') {
    $filterCondition = "WHERE users.state = 'inactive'";
} elseif ($filterBy === 'usersOnly') {
    $filterCondition = "WHERE users.role = 'user'";
} elseif ($filterBy === 'adminsOnly') {
    $filterCondition = "WHERE users.role = 'admin'";
}

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

        // Each word can match firstName, lastName, role, state, or points
        $conditions[] = "(users.firstName LIKE '%$wordSafe%' 
                          OR users.lastName LIKE '%$wordSafe%' 
                          OR users.role LIKE '%$wordSafe%'
                          OR users.state LIKE '%$wordSafe%'
                          OR users.points LIKE '%$wordSafe%')";
    }

    // Decide prefix depending on whether filterCondition already exists
    $prefix = empty($filterCondition) ? "WHERE" : "AND";
    $searchCondition = " $prefix (" . implode(" AND ", $conditions) . ")";
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