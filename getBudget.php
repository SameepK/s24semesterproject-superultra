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

// Check for GET request to fetch data
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Prepare the SELECT statement to fetch all goals
    $sql = "SELECT id, GoalsName, TotalAmount, CurrentBudget FROM newGoal";
    $result = $conn->query($sql);

    if ($result === false) {
        // Handle query error
        echo json_encode(['success' => false, 'message' => "Failed to fetch goals: " . $conn->error]);
        exit;
    } else {
        // Fetch all rows as an associative array
        $goals = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'goals' => $goals]);
    }
} else {
    // Handle non-GET requests
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close connection
$conn->close();
?>
