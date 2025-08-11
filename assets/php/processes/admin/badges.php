<?php

$badgeNameError = $descriptionError = $requirementValueError = $iconUrlError = '';

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

$badgeImageDir = __DIR__ . '/../../../../assets/img/badges/';

// (BADGES) - ADD / INSERT QUERY
if (isset($_POST['btnAdd'])) {
    $badgeName = trim($_POST['badgeName']);
    $description = trim($_POST['description']);
    $requirementValue = trim($_POST['requirementValue']);
    $iconUrl = '';
    $hasError = false;

    // Input validations
    if (!preg_match('/^[a-zA-Z0-9\s\-\.\,\!\?\:\;\'\"\(\)]+$/', $badgeName)) {
        $badgeNameError = "Badge name contains disallowed special characters.";
        $hasError = true;
    }

    if (!preg_match('/^[a-zA-Z0-9\s\-\.\,\!\?\:\;\'\"\(\)]+$/', $description)) {
        $descriptionError = "Description contains disallowed special characters.";
        $hasError = true;
    }

    if (!preg_match('/^[1-9][0-9]*$/', $requirementValue)) {
        $requirementValueError = "Requirement value must be a positive integer.";
        $hasError = true;
    }

    // Check if a file is selected at all
    if (empty($_FILES['iconUrl']['name'])) {
        $iconUrlError = "Please select an icon file.";
        $hasError = true;
    }

    // Proceed only if initial validations pass
    if (!$hasError) {
        $normalizedBadgeName = strtolower(trim($badgeName));
        $normalizedDescription = strtolower(trim($description));
        $normalizedRequirement = trim($requirementValue);

        $normalizedIconUrl = strtolower(trim(basename($_FILES['iconUrl']['name'])));

        $checkQuery = "SELECT * FROM badges";
        $result = mysqli_query($conn, $checkQuery);

        while ($row = mysqli_fetch_assoc($result)) {
            if (strtolower(trim($row['badgeName'])) === $normalizedBadgeName) {
                $badgeNameError = "Badge name already exists.";
                $hasError = true;
            }
            if (strtolower(trim($row['description'])) === $normalizedDescription) {
                $descriptionError = "Description already exists.";
                $hasError = true;
            }
            if (trim($row['requirementValue']) == $normalizedRequirement) {
                $requirementValueError = "Requirement value already exists.";
                $hasError = true;
            }
            if (strtolower(trim($row['iconUrl'])) === $normalizedIconUrl) {
                $iconUrlError = "Icon is already used.";
                $hasError = true;
            }
        }
    }

    // Now upload image ONLY if no errors
    if (!$hasError) {
        $fileName = basename($_FILES['iconUrl']['name']);
        $uploadPath = $badgeImageDir . $fileName;
        $fileType = mime_content_type($_FILES['iconUrl']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png'];

        if (!in_array($fileType, $allowedTypes)) {
            $iconUrlError = "Only JPG and PNG files are allowed.";
            $hasError = true;
        } elseif (!move_uploaded_file($_FILES['iconUrl']['tmp_name'], $uploadPath)) {
            $iconUrlError = "Failed to upload icon.";
            $hasError = true;
        } else {
            $iconUrl = $fileName;
        }
    }

    // Final insertion
    if (!$hasError) {
        $insertQuery = "INSERT INTO badges (badgeName, description, requirementValue, iconUrl)
                        VALUES ('$badgeName', '$description', '$requirementValue', '$iconUrl')";
        executeQuery($insertQuery);
        header("Location: " . $_SERVER['PHP_SELF'] . "?added=1&addBadgeId=" . $addBadgeId);
        exit;
    }
}


// (BADGES) - UPDATE / EDIT QUERY
if (isset($_POST['btnEdit'])) {
    $badgeID = $_POST['badgeID'];

    $badgeName = trim($_POST['badgeName']);
    $description = trim($_POST['description']);
    $requirementValue = trim($_POST['requirementValue']);
    $iconUrl = '';
    $hasError = false;

    $badgeNameErrorVar = "badgeNameError_$badgeID";
    $descriptionErrorVar = "descriptionError_$badgeID";
    $requirementValueErrorVar = "requirementValueError_$badgeID";
    $iconUrlErrorVar = "iconUrlError_$badgeID";

    // Validations  
    if (!preg_match('/^[a-zA-Z0-9\s\-\.\,\!\?\:\;\'\"\(\)]+$/', $badgeName)) {
        ${$badgeNameErrorVar} = "Badge name must not contain special characters.";
        $hasError = true;
    }

    if (!preg_match('/^[a-zA-Z0-9\s\-\.\,\!\?\:\;\'\"\(\)]+$/', $description)) {
        ${$descriptionErrorVar} = "Description must not contain special characters.";
        $hasError = true;
    }

    if (!preg_match('/^[1-9][0-9]*$/', $requirementValue)) {
        ${$requirementValueErrorVar} = "Requirement value must be a positive integer.";
        $hasError = true;
    }

    // Handle duplicate checking
    $tempIconName = !empty($_FILES['iconUrl']['name']) ? basename($_FILES['iconUrl']['name']) : $_POST['originalIconUrl'];
    $normalizedBadgeName = strtolower(trim($badgeName));
    $normalizedDescription = strtolower(trim($description));
    $normalizedIconUrl = strtolower(trim($tempIconName));

    $checkQuery = "SELECT * FROM badges WHERE badgeID != '$badgeID'";
    $result = mysqli_query($conn, $checkQuery);

    while ($row = mysqli_fetch_assoc($result)) {
        if (strtolower(trim($row['badgeName'])) === $normalizedBadgeName) {
            ${$badgeNameErrorVar} = "Badge name already exists.";
            $hasError = true;
        }
        if (strtolower(trim($row['description'])) === $normalizedDescription) {
            ${$descriptionErrorVar} = "Description already exists.";
            $hasError = true;
        }
        if (trim($row['requirementValue']) == $requirementValue) {
            ${$requirementValueErrorVar} = "Requirement value already exists.";
            $hasError = true;
        }
        if (strtolower(trim($row['iconUrl'])) === $normalizedIconUrl) {
            ${$iconUrlErrorVar} = "Icon is already used.";
            $hasError = true;
        }
    }

    // If no validation errors, then handle file upload
    if (!$hasError) {
        if (!empty($_FILES['iconUrl']['name'])) {
            if (!is_dir($badgeImageDir)) {
                mkdir($badgeImageDir, 0755, true);
            }

            $fileName = basename($_FILES['iconUrl']['name']);
            $uploadPath = $badgeImageDir . $fileName;
            $fileType = mime_content_type($_FILES['iconUrl']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png'];

            if (!in_array($fileType, $allowedTypes)) {
                ${$iconUrlErrorVar} = "Only JPG and PNG files are allowed.";
                $hasError = true;
            } elseif (!move_uploaded_file($_FILES['iconUrl']['tmp_name'], $uploadPath)) {
                ${$iconUrlErrorVar} = "Failed to upload icon.";
                $hasError = true;
            } else {
                $iconUrl = $fileName;

                if (!empty($_POST['originalIconUrl']) && $_POST['originalIconUrl'] !== $fileName) {
                    $oldIcon = $_POST['originalIconUrl'];
                    $countQuery = "SELECT COUNT(*) AS count FROM badges WHERE iconUrl = '$oldIcon'";
                    $countResult = mysqli_query($conn, $countQuery);
                    $countRow = mysqli_fetch_assoc($countResult);

                    if ($countRow['count'] <= 1) {
                        $oldIconPath = $badgeImageDir . $oldIcon;
                        if (file_exists($oldIconPath)) {
                            unlink($oldIconPath);
                        }
                    }
                }
            }
        } else {
            // No new upload, keep original icon 
            $iconUrl = $_POST['originalIconUrl'] ?? '';
            if (empty($iconUrl)) {
                ${$iconUrlErrorVar} = "Icon file is missing.";
                $hasError = true;
            }
        }
    }

    // Final update query
    if (!$hasError) {
        $safeBadgeName = mysqli_real_escape_string($conn, $badgeName);
        $safeDescription = mysqli_real_escape_string($conn, $description);
        $safeRequirementValue = mysqli_real_escape_string($conn, $requirementValue);
        $safeIconUrl = mysqli_real_escape_string($conn, $iconUrl);

        $updateQuery = "UPDATE badges 
                        SET badgeName = '$safeBadgeName', 
                            description = '$safeDescription', 
                            requirementValue = '$safeRequirementValue', 
                            iconUrl = '$safeIconUrl' 
                        WHERE badgeID = '$badgeID'";
        executeQuery($updateQuery);

        header("Location: " . $_SERVER['PHP_SELF'] . "?edited=1&editBadgeId=" . $badgeID);
        exit;
    }
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
        $filePath = $badgeImageDir . $iconUrl;
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
