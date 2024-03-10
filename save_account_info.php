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
    $name = $input['name']; // Corrected array key to match JSON keys sent from JS (case-sensitive)
    $account_number = $input['accountNumber']; // Corrected to match JSON keys
    $username = $input['username']; // Corrected to match JSON keys
    $password = $input['password']; // Corrected to match JSON keys
    $email = $input['email']; // Corrected to match JSON keys

    // Prepare the INSERT statement
    // Corrected column name from `Accoun_number` to `Account_number`
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

    // Return the saved account information
    echo json_encode(['success' => true, 'message' => 'Account information saved successfully', 'account_info' => $input]);
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch account information
    $sql_fetch = "SELECT * FROM `Account_info`";
    $result = $conn->query($sql_fetch);
    $accounts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
    }

    // Return the fetched account information
    echo json_encode(['success' => true, 'accounts' => $accounts]);
} else {
    // Handle other request methods
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close connection
$conn->close();
?>