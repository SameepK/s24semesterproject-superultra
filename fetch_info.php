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

// Check for GET request and userId parameter
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['userId'])) {
    // Prepare the SELECT statement to fetch user details
    $userId = $_GET['userId'];
    $sql = "SELECT Name, Accoun_number, Username, Password, Email FROM Account_info WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user details as an associative array
        $userDetails = $result->fetch_assoc();
        echo json_encode(['success' => true, 'userDetails' => $userDetails]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User details not found']);
    }

    // Close statement
    $stmt->close();
} else {
    // Handle invalid request
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

// Close connection
$conn->close();
?>
