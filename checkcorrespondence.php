<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Database connection details
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'ugoajaer';
$dbPassword = '50409878';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Extract username and password from GET request
$username = isset($_GET['username']) ? $_GET['username'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
    exit;
}

// Prepare SQL statement
$stmt = $conn->prepare("SELECT * FROM peace WHERE email = ?");

// Bind parameters
$stmt->bind_param("s", $username);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Compare the plaintext password with the hashed password from the database
    if (password_verify($password, $user['password'])) {
        // Success
        echo json_encode(['success' => true]);
    } else {
        // Invalid password
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
} else {
    // No user found
    echo json_encode(['success' => false, 'message' => 'Invalid email or password...']);
}

// Close statement
$stmt->close();

// Close connection
$conn->close();
?>
