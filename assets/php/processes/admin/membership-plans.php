<?php
$sortBy = $_GET['sortBy'] ?? 'membershipID';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = ['membershipID', 'planType', 'requirement', 'price'];
$allowedOrder = ['ASC', 'DESC'];

if (!in_array($sortBy, $allowedSortColumns) || !in_array($orderBy, $allowedOrder)) {
    $sortBy = 'membershipID';
    $orderBy = 'ASC';
}
if ($sortBy === 'requirement' || $sortBy === 'planType') {
    $orderCondition = "ORDER BY CAST(SUBSTRING_INDEX(requirement, ' ', 1) AS UNSIGNED) $orderBy";
} else {
    $orderCondition = "ORDER BY $sortBy $orderBy";
}


// PAGINATION
$entriesCount = isset($_GET['entriesCount']) ? (int) $_GET['entriesCount'] : 5;
if (!in_array($entriesCount, [5, 10, 25, 50]))
    $entriesCount = 5;

$currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($currentPage - 1) * $entriesCount;

// TOTAL MATCHING ENTRIES
$totalQuery = "SELECT COUNT(*) AS total FROM memberships";
$totalResult = executeQuery($totalQuery);
$totalEntries = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalEntries / $entriesCount);
$range = 1;
$start = max(1, $currentPage - $range);
$end = min($totalPages, $currentPage + $range);
$startEntry = ($totalEntries > 0) ? $offset + 1 : 0;
$endEntry = ($totalEntries > 0) ? min($offset + $entriesCount, $totalEntries) : 0;

// MAIN QUERY
$membershipPlanInfoArray = [];
$membershipPlanQuery = "
    SELECT * FROM memberships
    $orderCondition
    LIMIT $entriesCount OFFSET $offset
";
$result = executeQuery($membershipPlanQuery);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $membershipPlanInfoArray[] = $row;
    }
}

// ADD MEMBERSHIP PLAN
if (isset($_POST['btnAddMembershipPlan'])) {
    $_SESSION['planType'] = $_POST['planType'] ?? '';
    $_SESSION['requirement'] = $_POST['requirement'] ?? '';
    $_SESSION['price'] = $_POST['price'] ?? '';

    $planType = trim($_SESSION['planType']);
    $requirement = trim($_SESSION['requirement']);
    $price = trim($_SESSION['price']);

    $errors = [];

    if ($planType === '') {
        $errors['planType'] = "Plan type is required.";
    } elseif (!preg_match('/^[a-zA-Z0-9\- ]+$/', $planType)) {
        $errors['planType'] = "Plan type must not contain special characters.";
    }

    if (!preg_match('/^[1-9]\d*\s+days?$/i', $requirement)) {
        $errors['requirement'] = "Requirement must include a valid number followed by 'day(s)'.";
    } elseif (!preg_match('/^[a-zA-Z0-9\- ]+$/', $requirement)) {
        $errors['requirement'] = "Requirement must not contain special characters.";
    }
    

    if (!preg_match('/^\d+\.00$/', $price)) {
        $errors['price'] = "Price must be in valid format ending with .00 (e.g., 100.00).";
    } elseif (preg_match('/[^0-9.]/', $price)) {
        $errors['price'] = "Price must not contain special characters.";
    }



    if (isDuplicateMembership($conn, $planType, $requirement, $price, $membershipID ?? null)) {
        $errors['planType'] = "This exact plan type, requirement, and price already exists.";
        $errors['requirement'] = "This exact plan type, requirement, and price already exists.";
        $errors['price'] = "This exact plan type, requirement, and price already exists.";
    } else {
        if (isDuplicatePlanReq($conn, $planType, $requirement, $membershipID ?? null)) {
            $errors['planType'] = "This plan type and requirement combination already exists.";
            $errors['requirement'] = "This plan type and requirement combination already exists.";
        }

        if (isDuplicateRequirementPrice($conn, $requirement, $price, $membershipID ?? null)) {
            $errors['requirement'] = "This requirement and price combination already exists.";
            $errors['price'] = "This requirement and price combination already exists.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['addPlanErrors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $insertQuery = "
            INSERT INTO memberships (planType, requirement, price)
            VALUES ('$planType', '$requirement', '$price')
        ";
        executeQuery($insertQuery);

        unset($_SESSION['planType'], $_SESSION['requirement'], $_SESSION['price'], $_SESSION['addPlanErrors']);
        header("Location: " . $_SERVER['PHP_SELF'] . "?added=1&page=$currentPage&entriesCount=$entriesCount");
        exit;
    }
}

// EDIT PLAN
if (isset($_POST['btnEditMembershipPlan'])) {
    $membershipID = (int) $_POST['membershipID'];
    $planType = trim($_POST['planType']);
    $requirement = trim($_POST['requirement']);
    $price = trim($_POST['price']);

    $errors = [];

    if ($planType === '') {
        $errors['planType'] = "Plan type is required.";
    } elseif (!preg_match('/^[a-zA-Z0-9\- ]+$/', $planType)) {
        $errors['planType'] = "Plan type must not contain special characters.";
    }

    if (!preg_match('/^[1-9]\d*\s+days?$/i', $requirement)) {
        $errors['requirement'] = "Requirement must include a valid number followed by 'day(s)'.";
    } elseif (!preg_match('/^[a-zA-Z0-9\- ]+$/', $requirement)) {
        $errors['requirement'] = "Requirement must not contain special characters.";
    }

    if (!preg_match('/^\d+\.00$/', $price)) {
        $errors['price'] = "Price must be in valid format ending with .00 (e.g., 100.00).";
    } elseif (preg_match('/[^0-9.]/', $price)) {
        $errors['price'] = "Price must not contain special characters.";
    }


    if (isDuplicateMembership($conn, $planType, $requirement, $price, $membershipID ?? null)) {
        $errors['planType'] = "This exact plan type, requirement, and price already exists.";
        $errors['requirement'] = "This exact plan type, requirement, and price already exists.";
        $errors['price'] = "This exact plan type, requirement, and price already exists.";
    } else {
        if (isDuplicatePlanReq($conn, $planType, $requirement, $membershipID ?? null)) {
            $errors['planType'] = "This plan type and requirement combination already exists.";
            $errors['requirement'] = "This plan type and requirement combination already exists.";
        }

        if (isDuplicateRequirementPrice($conn, $requirement, $price, $membershipID ?? null)) {
            $errors['requirement'] = "This requirement and price combination already exists.";
            $errors['price'] = "This requirement and price combination already exists.";
        }
    }


    if (!empty($errors)) {
        $_SESSION['editPlanErrors'][$membershipID] = $errors;
        $_SESSION['editPlanData'][$membershipID] = compact('planType', 'requirement', 'price');
        header("Location: " . $_SERVER['PHP_SELF'] . "?editError=1&editID=$membershipID&page=$currentPage&entriesCount=$entriesCount");
        exit;
    }

    $planType = mysqli_real_escape_string($conn, $planType);
    $requirement = mysqli_real_escape_string($conn, $requirement);
    $price = mysqli_real_escape_string($conn, $price);

    $updateQuery = "
        UPDATE memberships 
        SET planType = '$planType', requirement = '$requirement', price = '$price' 
        WHERE membershipID = $membershipID
    ";
    executeQuery($updateQuery);

    header("Location: " . $_SERVER['PHP_SELF'] . "?updated=1&updatedID=$membershipID&page=$currentPage&entriesCount=$entriesCount");
    exit;
}

// DELETE PLAN
if (isset($_POST['btnDeleteMembershipPlan'])) {
    $membershipID = (int) $_POST['membershipID'];
    $planType = mysqli_real_escape_string($conn, $_POST['planType']);

    $deleteQuery = "DELETE FROM memberships WHERE membershipID = $membershipID";
    executeQuery($deleteQuery);

    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1&deletedID=$membershipID&planType=$planType&page=$currentPage&entriesCount=$entriesCount");
    exit;
}
function isDuplicateMembership($conn, $planType, $requirement, $price, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $requirementEsc = strtolower(mysqli_real_escape_string($conn, $requirement));
    $priceEsc = mysqli_real_escape_string($conn, $price);

    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships 
        WHERE LOWER(planType) = '$planTypeEsc' 
          AND LOWER(requirement) = '$requirementEsc' 
          AND price = '$priceEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}

function isDuplicatePlanReq($conn, $planType, $requirement, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $requirementEsc = strtolower(mysqli_real_escape_string($conn, $requirement));
    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(planType) = '$planTypeEsc'
          AND LOWER(requirement) = '$requirementEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}

function isDuplicateRequirementPrice($conn, $requirement, $price, $excludeID = null)
{
    $requirementEsc = strtolower(mysqli_real_escape_string($conn, $requirement));
    $priceEsc = mysqli_real_escape_string($conn, $price);
    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(requirement) = '$requirementEsc'
          AND price = '$priceEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}

?>