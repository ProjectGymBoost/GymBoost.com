<?php
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

        // Each word can match firstName, lastName, RFID, or dates
        $conditions[] = "(
            u.firstName LIKE '%$wordSafe%' 
            OR u.lastName LIKE '%$wordSafe%' 
            OR u.rfidNumber LIKE '%$wordSafe%' 
            OR um.startDate LIKE '%$wordSafe%' 
            OR um.endDate LIKE '%$wordSafe%'
        )";
    }

    // Require all words to match somewhere
    $searchCondition = " AND (" . implode(" AND ", $conditions) . ")";
}

// SORT AND ORDER BY
$sortBy = $_GET['sortBy'] ?? 'none';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = [
    'userMembershipID' => 'um.userMembershipID',
    'rfidNumber' => 'u.rfidNumber',
    'firstName' => 'u.firstName',
    'lastName' => 'u.lastName',
    'startDate' => 'um.startDate',
    'endDate' => 'um.endDate'
];

$allowedOrder = ['ASC', 'DESC'];

if (array_key_exists($sortBy, $allowedSortColumns) && in_array($orderBy, $allowedOrder)) {
    $column = $allowedSortColumns[$sortBy];
    $orderCondition = "ORDER BY $column $orderBy";
} else {
    // Default sort
    $orderCondition = "ORDER BY um.userMembershipID ASC";
}

// PAGINATION
$entriesCount = isset($_GET['entriesCount']) ? (int) $_GET['entriesCount'] : 5;
if (!in_array($entriesCount, [5, 10, 25, 50])) $entriesCount = 5;

$currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($currentPage - 1) * $entriesCount;

// COUNT TOTAL ENTRIES
$countQuery = "
    SELECT COUNT(*) AS total
    FROM users u
    INNER JOIN user_memberships um ON u.userID = um.userID
    WHERE u.role = 'user'
    $searchCondition
";
$countResult = executeQuery($countQuery);
$totalEntries = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalEntries / $entriesCount);

$range = 1;
$start = max(1, $currentPage - $range);
$end = min($totalPages, $currentPage + $range);

$startEntry = ($totalEntries > 0) ? $offset + 1 : 0;
$endEntry = ($totalEntries > 0) ? min($offset + $entriesCount, $totalEntries) : 0;

// MAIN QUERY
$membershipQuery = "
    SELECT 
        um.userMembershipID,
        u.userID,
        u.firstName,
        u.lastName,
        u.rfidNumber,
        um.membershipID,
        um.startDate,
        um.endDate
    FROM users u
    INNER JOIN user_memberships um ON u.userID = um.userID
    WHERE u.role = 'user'
    $searchCondition
    $orderCondition
    LIMIT $offset, $entriesCount
";


$membershipArray = [];
$membershipResult = executeQuery($membershipQuery);
if (mysqli_num_rows($membershipResult) > 0) {
    while ($row = mysqli_fetch_assoc($membershipResult)) {
        $membershipArray[] = array_map('htmlspecialchars', $row);
    }
}

// EDIT MEMBERSHIP
if (isset($_POST['btnEditMembership'])) {
    $editId = $_POST['editMembershipId'];
    $editStartDate = $_POST['editStartDate'];
    $editEndDate = $_POST['editEndDate'];
    $editMembershipPlan = $_POST['editMembershipPlan'];
    $editUserID = $_POST['editUserID'];
    $editRFID = mysqli_real_escape_string($conn, $_POST['editRFID']);

    // Update membership
    $updateQuery = "
        UPDATE user_memberships
        SET startDate = '$editStartDate', endDate = '$editEndDate',
        membershipID = $editMembershipPlan
        WHERE userMembershipID = $editId
    ";
    executeQuery($updateQuery);

    // Update RFID in users table
    $updateUserQuery = "UPDATE users SET rfidNumber = '$editRFID' WHERE userID = $editUserID";
    executeQuery($updateUserQuery);

    $editedName = $_POST['editFirstName'] . ' ' . $_POST['editLastName'];
    header("Location: " . $_SERVER['PHP_SELF'] .
        "?updated=1" .
        "&name=" . urlencode($editedName) .
        "&page=" . $currentPage .
        "&entriesCount=" . $entriesCount .
        "&search=" . urlencode($search) .
        "&sortBy=" . $sortBy .
        "&orderBy=" . $orderBy
    );
    exit;
}


// MEMBERSHIP PLANS QUERY
$membershipPlans = [];
$plansQuery = "SELECT membershipID, planType, validity FROM memberships ORDER BY membershipID ASC";
$plansResult = executeQuery($plansQuery);

if (mysqli_num_rows($plansResult) > 0) {
    while ($row = mysqli_fetch_assoc($plansResult)) {
        $membershipPlans[] = $row;
    }
}

// DELETE MEMBERSHIP
if (isset($_POST['btnDeleteMembership'])) {
    $deleteMembershipId = (int) $_POST['deleteMembershipId']; // cast to int for safety
    $deleteName = $_POST['deleteName'];

    // Get the userID linked to this membership
    $userQuery = "SELECT userID FROM user_memberships WHERE userMembershipID = $deleteMembershipId";
    $userResult = executeQuery($userQuery);
    $userRow = mysqli_fetch_assoc($userResult);
    $userID = $userRow ? (int) $userRow['userID'] : null;

    // Delete the membership
    $deleteQuery = "DELETE FROM user_memberships WHERE userMembershipID = $deleteMembershipId";
    $result = executeQuery($deleteQuery);

    if ($result && $userID) {
        // Mark the user as Inactive
        $updateStateQuery = "UPDATE users SET state = 'Inactive' WHERE userID = $userID";
        executeQuery($updateStateQuery);

        // Redirect with success message
        header(
            "Location: " . $_SERVER['PHP_SELF'] .
            "?deleted=1" .                                    
            "&deletedID=" . $deleteMembershipId .
            "&name=" . urlencode($deleteName) .
            "&page=" . $currentPage .
            "&entriesCount=" . $entriesCount .
            "&search=" . urlencode($search) .
            "&sortBy=" . $sortBy .
            "&orderBy=" . $orderBy
        );
        exit;
    }
}

$today = date('Y-m-d');

// Expire members
$expireQuery = "
    UPDATE users u
    JOIN (
        SELECT um.userID, MAX(um.endDate) AS latestEndDate
        FROM user_memberships um
        GROUP BY um.userID
    ) AS latest ON u.userID = latest.userID
    SET u.state = 'Inactive'
    WHERE latest.latestEndDate < '$today';
";
executeQuery($expireQuery);

// Reactivate valid members
$activateQuery = "
    UPDATE users u
    JOIN (
        SELECT um.userID, MAX(um.endDate) AS latestEndDate
        FROM user_memberships um
        GROUP BY um.userID
    ) AS latest ON u.userID = latest.userID
    SET u.state = 'Active'
    WHERE latest.latestEndDate >= '$today';
";
executeQuery($activateQuery);
