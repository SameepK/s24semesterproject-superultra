<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Database connection details
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'schen277';
$dbPassword = '50396261';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

// SQL to fetch the latest three categories
$sql = "SELECT Name, CurrentBudget, TotalBudget FROM Category ORDER BY id DESC LIMIT 3";

$result = $conn->query($sql);

if ($result) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode(['success' => true, 'categories' => $categories]);
} else {
    echo json_encode(['success' => false, 'message' => "Error fetching categories: " . $conn->error]);
}

$conn->close();
?>
