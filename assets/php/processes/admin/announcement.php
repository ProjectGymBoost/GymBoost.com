<?php
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

$startEntry = ($totalEntries > 0) ? $offset + 1 : 0;
$endEntry = ($totalEntries > 0) ? min($offset + $entriesCount, $totalEntries) : 0;

// MAIN QUERY
$announcementInfoArray = [];
$announcementQuery = "
    SELECT * FROM announcements
    ORDER BY announcementID ASC
    LIMIT $entriesCount OFFSET $offset
";
$result = executeQuery($announcementQuery);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $announcementInfoArray[] = $row;
    }
}
?>
