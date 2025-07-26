<?php
require_once '../../../shared/connect.php';
require_once __DIR__ . '/../../classes/classes.php'; 
session_start();

header('Content-Type: application/json');

$userID = $_SESSION['userID'] ?? null;
$year = $_GET['year'] ?? date('Y');

if (!$userID) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

$chart = new UserChartData($userID, $year);

try {
    $chart->loadWorkoutTypeData();
    $chart->loadMonthlyWorkoutData();
    $chart->loadAvailableYears();

    echo json_encode([
        "success" => true,
        "typeData" => array_map(function ($label, $count) {
            return ['workoutType' => $label, 'count' => $count];
        }, $chart->getTypeLabels(), $chart->getTypeCounts()),
        "monthlyData" => $chart->getMonthlyCounts()
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch workout data.",
        "error" => $e->getMessage()
    ]);
}
?>