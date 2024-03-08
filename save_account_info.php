<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); // Ensure JSON response

// Database connection details
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'sameepko';
$dbPassword = '50408723';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Handle POST request to save account information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get JSON input and decode it
    $input = json_decode(file_get_contents('php://input'), true);
    $accountNumber = $input['accountNumber'];
    $name = $input['name'];

    // Prepare the INSERT statement
    $sql = "INSERT INTO peace (Account_number, Name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    // Bind parameters and execute
    $stmt->bind_param("ss", $accountNumber, $name);
    if (!$stmt->execute()) {
        // Echo detailed error message
        echo json_encode(['success' => false, 'message' => 'Failed to save account information. Error: ' . $stmt->error]);
        exit;
    } else {
        echo json_encode(['success' => true, 'message' => 'Account information saved successfully']);
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
