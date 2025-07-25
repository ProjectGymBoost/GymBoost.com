<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../../../shared/connect.php");

header('Content-Type: application/json');

$response = [
    "topMembers" => [],
    "stats" => [
        "totalUsers" => 0,
        "activeMembers" => 0,
        "inactiveMembers" => 0,
        "newMembers" => 0,
        "attendanceToday" => 0,
        "totalPlans" => 0
    ]
];

try {
    // TOP MEMBERS
    $startOfMonth = date('Y-m-01');
    $endOfMonth = date('Y-m-t');

    $stmt = $conn->prepare("
        SELECT 
            u.userID,
            CONCAT(u.firstName, ' ', u.lastName) AS fullName,
            COUNT(DISTINCT w.workoutID) AS workoutsThisMonth,
            COUNT(DISTINCT a.attendanceID) * 5 AS points
        FROM users u
        LEFT JOIN workout_logs w 
            ON u.userID = w.userID 
            AND DATE(w.startDate) BETWEEN ? AND ?
        LEFT JOIN attendances a
            ON u.userID = a.userID 
            AND DATE(a.checkinDate) BETWEEN ? AND ?
        WHERE u.state = 'Active'
        AND u.role = 'user'
        GROUP BY u.userID
        ORDER BY workoutsThisMonth DESC, points DESC
        LIMIT 10
    ");
    $stmt->bind_param("ssss", $startOfMonth, $endOfMonth, $startOfMonth, $endOfMonth);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response['topMembers'][] = $row;
    }

    // DASHBOARD STATS
    $dashboardQueries = [
        'totalUsers' => "SELECT COUNT(*) AS count FROM users",
        'activeMembers' => "SELECT COUNT(*) AS count FROM users WHERE state = 'Active'",
        'inactiveMembers' => "SELECT COUNT(*) AS count FROM users WHERE state = 'Inactive'",
        'newMembers' => "SELECT COUNT(DISTINCT userID) AS count FROM user_memberships WHERE DATE(startDate) >= CURDATE() - INTERVAL 7 DAY",
        'attendanceToday' => "SELECT COUNT(*) AS count FROM attendances WHERE DATE(checkinDate) = CURDATE()",
        'totalPlans' => "SELECT COUNT(*) AS count FROM memberships"
    ];

    foreach ($dashboardQueries as $key => $sql) {
        $dashboardResult = mysqli_query($conn, $sql);
        if ($dashboardResult && $row = mysqli_fetch_assoc($dashboardResult)) {
            $response['stats'][$key] = $row['count'] ?? 0;
        }
    }

    echo json_encode($response);
} catch (Exception $e) {
    error_log("Error in admin/index.php: " . $e->getMessage());
    echo json_encode($response); // fallback to empty/default values
}
