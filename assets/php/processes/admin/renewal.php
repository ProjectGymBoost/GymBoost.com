<?php
if (isset($_POST['btnRenew'])) {
    include("../../../shared/connect.php");

    $userID = $_POST['userID'];
    $membershipID = $_POST['membershipID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Check if the user is still Active
    $statusQuery = "SELECT state FROM users WHERE userID = $userID";
    $statusResult = executeQuery($statusQuery);
    $statusRow = mysqli_fetch_assoc($statusResult);

    if ($statusRow && $statusRow['state'] === "Active") {
        // Redirect with warning if the user is still active
        header("Location: renewal.php?active=1");
        exit;
    }

    // Proceed with inserting new membership
    $query = "
        INSERT INTO user_memberships (userID, membershipID, startDate, endDate)
        VALUES ($userID, $membershipID, '$startDate', '$endDate')
    ";
    $result = executeQuery($query);

    if ($result) {
        header("Location: membership.php?renewed=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
