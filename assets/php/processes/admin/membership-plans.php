<?php
$sortBy = $_GET['sortBy'] ?? 'membershipID';
$orderBy = isset($_GET['orderBy']) ? strtoupper($_GET['orderBy']) : 'ASC';

$allowedSortColumns = ['membershipID', 'planType', 'validity', 'price'];
$allowedOrder = ['ASC', 'DESC'];

if (!in_array($sortBy, $allowedSortColumns) || !in_array($orderBy, $allowedOrder)) {
    $sortBy = 'membershipID';
    $orderBy = 'ASC';
}
if ($sortBy === 'validity' || $sortBy === 'planType') {
    $orderCondition = "ORDER BY CAST(SUBSTRING_INDEX(validity, ' ', 1) AS UNSIGNED) $orderBy";
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
    $_SESSION['validity'] = $_POST['validity'] ?? '';
    $_SESSION['price'] = $_POST['price'] ?? '';

    $planType = trim($_SESSION['planType']);
    $validity = trim($_SESSION['validity']);
    $price = trim($_SESSION['price']);

    $errors = [];

    if ($planType === '') {
        $errors['planType'] = "Plan type is required.";
    } elseif (!preg_match('/^[a-zA-Z0-9\- ]+$/', $planType)) {
        $errors['planType'] = "Plan type must not contain special characters.";
    }

    if (!preg_match('/^(\d+)\s+(day|days)$/i', $validity, $matches)) {
        $errors['validity'] = "Requires a valid number with 'day(s).'";
    } else {
        $number = (int) $matches[1];
        $unit = strtolower($matches[2]);

        if (($number === 1 && $unit !== 'day') || ($number !== 1 && $unit !== 'days')) {
            $errors['validity'] = "Use 'day' for 1 and 'days' for numbers greater than 1.";
        }
    }

    if (empty($errors) && !preg_match('/^[a-zA-Z0-9\- ]+$/', $validity)) {
        $errors['validity'] = "Validity must not contain special characters.";
    }
    if (!preg_match('/^\d{1,3}(?:,\d{3})*(\.\d{2})?$/', $price)) {
        $errors['price'] = "Use valid price format (600.00 or 1,200.50).";
    } else {
        $price = str_replace(',', '', $price);

        if (!strpos($price, '.')) {
            $price .= '.00';
        }
    }


    if (isDuplicateMembership($conn, $planType, $validity, $price, $membershipID ?? null)) {
        $errors['planType'] = "";
        $errors['validity'] = "";
        $errors['price'] = "This exact membership plan already exists.";
    } else {
        if (isDuplicatePlanReq($conn, $planType, $validity, $membershipID ?? null)) {
            $errors['planType'] = "";
            $errors['validity'] = "This plan type and validity already exists.";
        }

        if (isDuplicatevalidityPrice($conn, $validity, $price, $membershipID ?? null)) {
            $errors['validity'] = "";
            $errors['price'] = "This validity and price already exists.";
        }
        if (isDuplicatePlanTypeAndPrice($conn, $planType, $price, $membershipID ?? null)) {
            $errors['planType'] = "";
            $errors['price'] = "This plan type and price already exists.";
        }
        if (isDuplicatePlanType($conn, $planType)) {
            $errors['planType'] = "This plan type name already exists.";
        }

    }

    if (!empty($errors)) {
        $_SESSION['addPlanErrors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF'] . "?addError=1&page=$currentPage&entriesCount=$entriesCount");
        exit;
    } else {
        $insertQuery = "
            INSERT INTO memberships (planType, validity, price)
            VALUES ('$planType', '$validity', '$price')
        ";
        executeQuery($insertQuery);

        unset($_SESSION['planType'], $_SESSION['validity'], $_SESSION['price'], $_SESSION['addPlanErrors']);
        header("Location: " . $_SERVER['PHP_SELF'] . "?added=1&planTypeAdded=$planType&page=$currentPage&entriesCount=$entriesCount");
        exit;
    }
}

// EDIT PLAN
if (isset($_POST['btnEditMembershipPlan'])) {
    $membershipID = (int) $_POST['membershipID'];
    $planType = trim($_POST['planType']);
    $validity = trim($_POST['validity']);
    $price = str_replace(',', '', $_POST['price']);
    $price = (float) $price;

    $errors = [];

    $existingQuery = "SELECT * FROM memberships WHERE membershipID = $membershipID";
    $existingResult = executeQuery($existingQuery);
    $existingPlan = mysqli_fetch_assoc($existingResult);

    $existingPlanType = $existingPlan['planType'];
    $existingvalidity = $existingPlan['validity'];
    $existingPrice = $existingPlan['price'];

    $isPlanModified = ($planType !== $existingPlanType || $validity !== $existingvalidity);
    $isPriceModified = ($price !== $existingPrice);

    if ($planType === '') {
        $errors['planType'] = "Plan type is required.";
    } elseif (!preg_match('/^[a-zA-Z0-9\- ]+$/', $planType)) {
        $errors['planType'] = "Plan type must not contain special characters.";
    }

    if (!preg_match('/^(\d+)\s+(day|days)$/i', $validity, $matches)) {
        $errors['validity'] = "Requires a valid number with 'day(s).'";
    } else {
        $number = (int) $matches[1];
        $unit = strtolower($matches[2]);
        if (($number === 1 && $unit !== 'day') || ($number !== 1 && $unit !== 'days')) {
            $errors['validity'] = "Use 'day' for 1, 'days' for greater than 1.";
        }
    }

    if (empty($errors) && !preg_match('/^[a-zA-Z0-9\- ]+$/', $validity)) {
        $errors['validity'] = "Validity must not contain special characters.";
    }

    if (!preg_match('/^\d{1,3}(?:,\d{3})*(?:\.\d{2})?$/', $_POST['price']) && !preg_match('/^\d+(\.\d{2})?$/', $_POST['price'])) {
        $errors['price'] = "Use valid price format (600.00 or 1,200.50).";
    } elseif (preg_match('/[^0-9,\.]/', $_POST['price'])) {
        $errors['price'] = "Price must not contain special characters.";
    } elseif (strpos($_POST['price'], '-') !== false && strpos($_POST['price'], '-') !== 0) {
        $errors['price'] = "Price cannot contain negative signs.";
    }

    if ($isPriceModified) {
        if (isDuplicateMembership($conn, $planType, $validity, $price, $membershipID)) {
            $errors['planType'] = "";
            $errors['validity'] = "";
            $errors['price'] = "This exact membership plan already exists.";
        }
    }

    if ($isPlanModified && !$isPriceModified) {
        if (isDuplicatePlanReq($conn, $planType, $validity, $membershipID)) {
            $errors['planType'] = "";
            $errors['validity'] = "This plan type and validity already exists.";
        }
    }

    if (isDuplicatePlanTypeAndPrice($conn, $planType, $price, $membershipID ?? null)) {
        $errors['planType'] = "";
        $errors['price'] = "This plan type and price already exists.";
    }

    if (isDuplicatePlanTypeAndvalidity($conn, $planType, $validity, $price, $membershipID ?? null)) {
        $errors['planType'] = "";
        $errors['validity'] = "This plan type and validity already exists.";
    }
    if ($planType !== $existingPlanType && isDuplicatePlanType($conn, $planType, $membershipID)) {
        $errors['planType'] = "This plan type name already exists.";
    }


    if (empty($errors)) {
        $planType = mysqli_real_escape_string($conn, $planType);
        $validity = mysqli_real_escape_string($conn, $validity);
        $price = mysqli_real_escape_string($conn, $price);

        $updateQuery = "
            UPDATE memberships 
            SET planType = '$planType', validity = '$validity', price = '$price' 
            WHERE membershipID = $membershipID
        ";
        executeQuery($updateQuery);

        header("Location: " . $_SERVER['PHP_SELF'] . "?updated=1&updatedID=$membershipID&page=$currentPage&entriesCount=$entriesCount");
        exit;
    } else {
        $_SESSION['editPlanErrors'][$membershipID] = $errors;
        $_SESSION['editPlanData'][$membershipID] = compact('planType', 'validity', 'price');
        header("Location: " . $_SERVER['PHP_SELF'] . "?editError=1&editID=$membershipID&page=$currentPage&entriesCount=$entriesCount");
        exit;
    }
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
function isDuplicateMembership($conn, $planType, $validity, $price, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $validityEsc = strtolower(mysqli_real_escape_string($conn, $validity));
    $priceEsc = mysqli_real_escape_string($conn, $price);

    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships 
        WHERE LOWER(planType) = '$planTypeEsc' 
          AND LOWER(validity) = '$validityEsc' 
          AND price = '$priceEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}

function isDuplicatePlanReq($conn, $planType, $validity, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $validityEsc = strtolower(mysqli_real_escape_string($conn, $validity));
    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(planType) = '$planTypeEsc'
          AND LOWER(validity) = '$validityEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}

function isDuplicatevalidityPrice($conn, $validity, $price, $excludeID = null)
{
    $validityEsc = strtolower(mysqli_real_escape_string($conn, $validity));
    $priceEsc = mysqli_real_escape_string($conn, $price);
    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(validity) = '$validityEsc'
          AND price = '$priceEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}
function isDuplicatePlanTypeAndPrice($conn, $planType, $price, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $priceEsc = mysqli_real_escape_string($conn, $price);

    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(planType) = '$planTypeEsc'
          AND price = '$priceEsc'
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}
function isDuplicatePlanTypeAndvalidity($conn, $planType, $validity, $price, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $validityEsc = strtolower(mysqli_real_escape_string($conn, $validity));
    $priceEsc = mysqli_real_escape_string($conn, $price);

    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(planType) = '$planTypeEsc'
          AND LOWER(validity) = '$validityEsc'
          AND price != '$priceEsc'  -- Different price
          $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}
function isDuplicatePlanType($conn, $planType, $excludeID = null)
{
    $planTypeEsc = strtolower(mysqli_real_escape_string($conn, $planType));
    $excludeSQL = $excludeID ? "AND membershipID != $excludeID" : "";

    $sql = "
        SELECT membershipID FROM memberships
        WHERE LOWER(planType) = '$planTypeEsc'
        $excludeSQL
    ";

    $result = executeQuery($sql);
    return mysqli_num_rows($result) > 0;
}

?>