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