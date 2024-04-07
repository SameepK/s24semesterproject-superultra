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

$queryCreateTable = "CREATE TABLE IF NOT EXISTS Category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    CurrentBudget DECIMAL(10, 2) NOT NULL,
    TotalBudget DECIMAL(10, 2) NOT NULL
)";

if (!$conn->query($queryCreateTable)) {
    echo json_encode(['success' => false, 'message' => "Error creating table: " . $conn->error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $conn->real_escape_string($input['name']);
    $currentBudget = $conn->real_escape_string($input['currentBudget']);
    $totalBudget = $conn->real_escape_string($input['totalBudget']);

    $sql = "INSERT INTO Category (Name, CurrentBudget, TotalBudget) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sdd", $name, $currentBudget, $totalBudget);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to save category. Error: ' . $stmt->error]);
        exit;
    } else {
        echo json_encode(['success' => true, 'message' => 'Category saved successfully']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
