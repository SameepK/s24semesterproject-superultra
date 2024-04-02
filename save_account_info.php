<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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
    $name = $input['name'];
    $account_number = $input['accountNumber'];
    $username = $input['username'];
    $password = $input['password'];
    $email = $input['email'];

    // Prepare the INSERT statement
    $sql = "INSERT INTO `Account_info` (`Name`, `Accoun_number`, `Username`, `Password`, `Email`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    // Bind parameters and execute
    $stmt->bind_param("sssss", $name, $account_number, $username, $password, $email);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to save account information. Error: ' . $stmt->error]);
        exit;
    }

    // Close statement
    $stmt->close();

    // Get the ID of the saved record
    $userId = $conn->insert_id;

    // Close connection
    $conn->close();

    // Return success message and user ID
    echo json_encode(['success' => true, 'message' => 'Account information saved successfully', 'userId' => $userId]);
} else {
    // Handle other request methods
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
