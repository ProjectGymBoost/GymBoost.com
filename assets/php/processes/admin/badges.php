<?php
// (BADGES) - MAIN DATA QUERY
$badgeInfoQuery = "
    SELECT *
    FROM badges
";

$badgeInfoArray = [];
$badgeInfoResult = executeQuery($badgeInfoQuery);
if (mysqli_num_rows($badgeInfoResult) > 0) {
    while ($row = mysqli_fetch_assoc($badgeInfoResult)) {
        $badgeInfoArray[] = $row;
    }
}


// (BADGES) - ADD / INSERT QUERY
if (isset($_POST['btnAdd'])) {
    $badgeName = $_POST['badgeName'];
    $description = $_POST['description'];
    $requirementValue = $_POST['requirementValue'];
    $iconUrl = $_POST['iconUrl'];

    // Handle uploaded icon
    if (!empty($_FILES['iconUrl']['name'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/GymBoost.com/assets/img/badges/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES['iconUrl']['name']);
        $uploadPath = $targetDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = mime_content_type($_FILES['iconUrl']['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['iconUrl']['tmp_name'], $uploadPath)) {
                $iconUrl = $fileName;
            } else {
                echo "Upload failed: Could not move uploaded file.";
                exit;
            }
        } else {
            echo "Upload failed: Invalid file type.";
            exit;
        }
    }

    $insertQuery = "INSERT INTO badges (badgeName, description, requirementValue, iconUrl)
                    VALUES ('$badgeName', '$description', '$requirementValue', '$iconUrl')";

    executeQuery($insertQuery);

    header(
        "Location: " . $_SERVER['PHP_SELF'] .
        "?added=1&addBadgeId=" . $addBadgeId
    );
    exit;
}


// (BADGES) - EDIT QUERY
if (isset($_POST['btnEdit'])) {
    $badgeID = $_POST['badgeID'];
    $badgeName = $_POST['badgeName'];
    $description = $_POST['description'];
    $requirementValue = $_POST['requirementValue'];
    $iconUrl = $_POST['iconUrl'];

    // Handle uploaded icon
    if (!empty($_FILES['iconUrl']['name'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/GymBoost.com/assets/img/badges/';

        // Create the folder if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES['iconUrl']['name']);
        $uploadPath = $targetDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = mime_content_type($_FILES['iconUrl']['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {

            $fetchOldIconQuery = "SELECT iconUrl FROM badges WHERE badgeID = '$badgeID'";
            $result = executeQuery($fetchOldIconQuery);
            $oldIcon = null;
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $oldIcon = $row['iconUrl'];
            }

            // Upload new image
            if (move_uploaded_file($_FILES['iconUrl']['tmp_name'], $uploadPath)) {
                $iconUrl = $fileName;

                // Delete the old image after successful upload
                if ($oldIcon) {
                    $oldIconPath = $_SERVER['DOCUMENT_ROOT'] . '/GymBoost.com/assets/img/badges/' . $oldIcon;
                    if (file_exists($oldIconPath) && $oldIcon !== $fileName) {
                        unlink($oldIconPath);
                    }
                }
            } else {
                echo "Upload failed: Could not move uploaded file.";
                exit;
            }
        } else {
            echo "Upload failed: Invalid file type.";
            exit;
        }
    }

    $editQuery = "UPDATE badges SET 
        badgeName = '$badgeName', 
        description = '$description', 
        requirementValue = '$requirementValue', 
        iconUrl = '$iconUrl'
        WHERE badgeID = '$badgeID'";

    executeQuery($editQuery);

    header(
        "Location: " . $_SERVER['PHP_SELF'] . "?edited=1&editBadgeId=" . $badgeID
    );
    exit;
}


// (BADGES) - DELETE QUERY
if (isset($_POST['btnDelete'])) {
    $deleteBadgeId = $_POST['deleteBadgeId'];
    $deleteBadgeName = $_POST['deleteBadgeName'];

    // Fetch the icon URL of the badge to be deleted
    $getIconQuery = "SELECT iconUrl FROM badges WHERE badgeID = $deleteBadgeId";
    $iconQueryResult = executeQuery($getIconQuery);

    if ($iconQueryResult && mysqli_num_rows($iconQueryResult) > 0) {
        $badgeToDelete = mysqli_fetch_assoc($iconQueryResult);
        $iconUrl = $badgeToDelete['iconUrl'];

        // Delete the uploaded icon file from the server directory
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/GymBoost.com/assets/img/badges/' . $iconUrl;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $deleteQuery = "DELETE FROM badges WHERE badgeID = $deleteBadgeId";
    executeQuery($deleteQuery);

    header(
        "Location: " . $_SERVER['PHP_SELF'] .
        "?deleted=1" .
        "&deleteBadgeId=" . $deleteBadgeId
    );
    exit;
}


// (USER-BADGES) - SEARCH
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$userSearch = !empty($search) ? mysqli_real_escape_string($conn, $search) : '';

$searchCondition = '';

if (!empty($userSearch)) {
    $searchCondition = "AND (
        user_badges.userBadgeID LIKE '%$userSearch%' 
        OR CONCAT(users.firstName, ' ', users.lastName) LIKE '%$userSearch%' 
        OR user_badges.badgeID LIKE '%$userSearch%' 
        OR user_badges.dateEarned LIKE '%$userSearch%'
    )";
}


// (USER-BADGES) - SORT AND ORDER BY
$sortBy = $_GET['sortBy'] ?? 'none';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = ['badgeID', 'username', 'dateEarned'];
$allowedOrder = ['ASC', 'DESC'];

if (in_array($sortBy, $allowedSortColumns) && in_array($orderBy, $allowedOrder)) {
    $orderCondition = "ORDER BY $sortBy $orderBy";
} else {
    $orderDirection = in_array($orderBy, $allowedOrder) ? $orderBy : 'ASC';
    $orderCondition = "ORDER BY userBadgeID $orderDirection";
}


// (USER-BADGES) - PAGINATION
$entriesCount = isset($_GET['entriesCount']) ? (int) $_GET['entriesCount'] : 5;
if (!in_array($entriesCount, [5, 10, 25, 50]))
    $entriesCount = 5;

$currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($currentPage - 1) * $entriesCount;


// (USER-BADGES) - TOTAL MATCHING ENTRIES
$totalQuery = "
    SELECT COUNT(*) AS total
    FROM user_badges
    JOIN users ON user_badges.userID = users.userID
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


// (USER-BADGES) - MAIN DATA QUERY
$userBadgeInfoQuery = "
    SELECT 
    user_badges.*, 
    CONCAT(users.firstName, ' ', users.lastName) AS username
    FROM 
        user_badges
    JOIN 
        users ON user_badges.userID = users.userID
    WHERE 
        users.role = 'user'
    $searchCondition
    $orderCondition
    LIMIT $entriesCount OFFSET $offset
";

$userBadgeInfoArray = [];
$userBadgeInfoResult = executeQuery($userBadgeInfoQuery);
if (mysqli_num_rows($userBadgeInfoResult) > 0) {
    while ($row = mysqli_fetch_assoc($userBadgeInfoResult)) {
        $userBadgeInfoArray[] = $row;
    }
}

// (USER-BADGES) - DELETE QUERY
if (isset($_POST['btnDeleteAlt'])) {
    $deleteUserBadgeId = $_POST['deleteUserBadgeId'];
    $deleteUsername = $_POST['deleteUsername'];

    $deleteQuery = "DELETE FROM user_badges WHERE userBadgeID = $deleteUserBadgeId";
    executeQuery($deleteQuery);

    header(
        "Location: " . $_SERVER['PHP_SELF'] .
        "?deleted=1" .
        "&deleteUserBadgeId=" . $deleteUserBadgeId .
        "&page=" . $currentPage .
        "&entriesCount=" . $entriesCount
    );
    exit;
}
