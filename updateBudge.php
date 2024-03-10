<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); // Ensure JSON response

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

// Create table if it doesn't exist
$queryCreateTable = "CREATE TABLE IF NOT EXISTS newGoal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    GoalsName VARCHAR(255) NOT NULL,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    CurrentBudget DECIMAL(10, 2) NOT NULL
)";

if (!$conn->query($queryCreateTable)) {
    echo json_encode(['success' => false, 'message' => "Error creating table: " . $conn->error]);
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get JSON input and decode it
    $input = json_decode(file_get_contents('php://input'), true);
    $goalsName = $input['goalsName'];
    $totalAmount = $input['totalAmount'];
    $currentBudget = $input['currentBudget'];

    // Prepare the INSERT statement
    $sql = "INSERT INTO newGoal (GoalsName, TotalAmount, CurrentBudget) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    // Bind parameters and execute
    $stmt->bind_param("sss", $goalsName, $totalAmount, $currentBudget);
    if (!$stmt->execute()) {
        // Echo detailed error message
        echo json_encode(['success' => false, 'message' => 'Failed to save goal. Error: ' . $stmt->error]);
        exit;
    }
    else {
        echo json_encode([
            'success' => true, 
            'message' => 'Goal saved successfully. Parameters - GoalsName: ' . $goalsName . ', TotalAmount: ' . $totalAmount . ', CurrentBudget: ' . $currentBudget
        ]);
    }
    
    

    // Close statement
    $stmt->close();
} else {
    // Handle non-POST requests
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close connection
$conn->close();
?>
