<?php
include('../../../shared/connect.php');

if (isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
    header('Content-Type: application/json');

    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $announcementsQuery = "SELECT * FROM announcements ORDER BY announcementID ASC LIMIT $limit OFFSET $offset";
    $announcementsResult = executeQuery($announcementsQuery);

    $totalQuery = "SELECT COUNT(*) AS total FROM announcements";
    $totalResult = executeQuery($totalQuery);

    if (!$announcementsResult || !$totalResult) {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        exit;
    }

    $announcements = [];
    while ($row = mysqli_fetch_assoc($announcementsResult)) {
        $announcements[] = $row;
    }

    $totalRow = mysqli_fetch_assoc($totalResult);
    $total = $totalRow ? (int)$totalRow['total'] : 0;

    echo json_encode([
        'status' => count($announcements) ? 'success' : 'empty',
        'data' => $announcements,
        'total' => $total,
        'page' => $page,
        'limit' => $limit
    ]);
    exit;
}
?>
