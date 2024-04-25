<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'schen277';
$dbPassword = '50396261';
$dbName = 'cse442_2024_spring_team_aa_db';

$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

function getAverageSpending($conn) {
    $query = "SELECT AVG(rent) AS avg_rent, AVG(food) AS avg_food, AVG(clothes) AS avg_clothes, AVG(gas) AS avg_gas, AVG(car) AS avg_car FROM `3001-4000ID`";
    $result = $conn->query($query);
    if ($result === false) {
        return ['success' => false, 'message' => "Query failed: " . $conn->error];
    }
    $data = $result->fetch_assoc();
    return ['success' => true, 'averages' => $data];  // Ensure success is always part of the return structure
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $averages = getAverageSpending($conn);
    echo json_encode($averages);
    $conn->close();
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>

