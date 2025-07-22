<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../../../shared/connect.php");

// Get current month's first and last day
$startOfMonth = date('Y-m-01');
$endOfMonth = date('Y-m-t');

// Prepare secure SQL query
$stmt = $conn->prepare("
    SELECT 
        u.userID,
        CONCAT(u.firstName, ' ', u.lastName) AS fullName,
        COUNT(w.workoutID) AS workoutsThisMonth,
        IFNULL(u.points, 0) AS points
    FROM users u
    LEFT JOIN workout_logs w 
        ON u.userID = w.userID 
        AND w.status = 'Completed' 
        AND DATE(w.workoutDate) BETWEEN ? AND ?
    WHERE u.state = 'Active'
    AND u.role = 'user'
    GROUP BY u.userID
    ORDER BY workoutsThisMonth DESC, points DESC
    LIMIT 10
");
$stmt->bind_param("ss", $startOfMonth, $endOfMonth);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}

header('Content-Type: application/json'); 
echo json_encode($members ?: []);
