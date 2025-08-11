<?php
// SEARCH
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchSafe = mysqli_real_escape_string($conn, $search);

$searchCondition = '';
if (!empty($searchSafe)) {
    $searchCondition = "WHERE (
        title LIKE '%$searchSafe%' 
        OR message LIKE '%$searchSafe%' 
        OR dateCreated LIKE '%$searchSafe%'
    )";
}

// SORT AND ORDER
$sortBy = $_GET['sortBy'] ?? 'announcementID';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = [
    'announcementID' => 'announcementID',
    'title'          => 'title',
    'message'        => 'message',
    'dateCreated'    => 'dateCreated'
];

$allowedOrder = ['ASC', 'DESC'];

// Validate and build ORDER BY clause
if (array_key_exists($sortBy, $allowedSortColumns) && in_array($orderBy, $allowedOrder)) {
    $orderCondition = "ORDER BY {$allowedSortColumns[$sortBy]} $orderBy";
} else {
    $orderCondition = "ORDER BY announcementID ASC";
}

// PAGINATION CONFIG
$entriesCount = isset($_GET['entriesCount']) ? (int) $_GET['entriesCount'] : 5;
if (!in_array($entriesCount, [5, 10, 25, 50])) {
    $entriesCount = 5;
}

$currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($currentPage - 1) * $entriesCount;

// TOTAL COUNT
$totalQuery = "SELECT COUNT(*) AS total FROM announcements";
$totalResult = executeQuery($totalQuery);
$totalEntries = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalEntries / $entriesCount);

$range = 1;
$start = max(1, $currentPage - $range);
$end = min($totalPages, $currentPage + $range);

$startEntry = ($totalEntries > 0) ? $offset + 1 : 0;
$endEntry = ($totalEntries > 0) ? min($offset + $entriesCount, $totalEntries) : 0;

// MAIN QUERY
$announcementInfoArray = [];
$announcementQuery = "
    SELECT * FROM announcements
    $searchCondition
    $orderCondition
    LIMIT $entriesCount OFFSET $offset
";
$result = executeQuery($announcementQuery);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $announcementInfoArray[] = $row;
    }
}

// ADD ANNOUNCEMENT
if (isset($_POST['btnAddAnnouncement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['newAnnouncementTitle']);
    $message = mysqli_real_escape_string($conn, $_POST['newAnnouncementMessage']);

    $insertQuery = "INSERT INTO announcements (title, message) VALUES ('$title', '$message')";
    executeQuery($insertQuery);

    header("Location: " . $_SERVER['PHP_SELF'] . "?added=1&page=$currentPage&entriesCount=$entriesCount");
    exit;
}

// EDIT ANNOUNCEMENT
if (isset($_POST['btnEditAnnouncement'])) {
    $id = $_POST['editAnnouncementID'];
    $title = mysqli_real_escape_string($conn, $_POST['editAnnouncementTitle']);
    $message = mysqli_real_escape_string($conn, $_POST['editAnnouncementMessage']);

    $updateQuery = "UPDATE announcements SET title = '$title', message = '$message' WHERE announcementID = $id";
    executeQuery($updateQuery);

    header("Location: " . $_SERVER['PHP_SELF'] . "?updated=1&highlight=$id&page=$currentPage&entriesCount=$entriesCount");
    exit;
}

// DELETE ANNOUNCEMENT
if (isset($_POST['btnDeleteAnnouncement'])) {
    $id = $_POST['deleteAnnouncementID'];

    $deleteQuery = "DELETE FROM announcements WHERE announcementID = $id";
    executeQuery($deleteQuery);

    $currentPage = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $entriesCount = isset($_POST['entriesCount']) ? (int) $_POST['entriesCount'] : 5;

    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1&highlight=$id&page=$currentPage&entriesCount=$entriesCount");
    exit;
}
?>