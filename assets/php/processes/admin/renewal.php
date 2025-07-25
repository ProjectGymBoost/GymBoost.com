<?php
if (isset($_POST['btnRenew'])) {
    include("../../../shared/connect.php");

    $userID = $_POST['userID'];
    $membershipID = $_POST['membershipID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Insert new membership entry (preserves history)
    $query = "INSERT INTO user_memberships (userID, membershipID, startDate, endDate)
              VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iiss", $userID, $membershipID, $startDate, $endDate);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: membership.php?renewed=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>