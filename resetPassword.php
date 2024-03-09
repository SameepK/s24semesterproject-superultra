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

// Extract username, old password, and new password from GET request
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'];
$oldPassword = $input['oldPassword'];
$newPassword = $input['newPassword'];

// Password requirements pattern
$passwordRequirements = '/(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}/';

if (empty($username) || empty($oldPassword) || empty($newPassword)) {
    echo json_encode(['success' => false, 'message' => 'Username, old password, and new password are required.']);
    exit;
}

// Check new password against requirements
if (!preg_match($passwordRequirements, $newPassword)) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.']);
    exit;
}

// Prepare SQL statement to fetch the user's current password
$stmt = $conn->prepare("SELECT password FROM peace WHERE email = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $currentHashedPassword = $user['password'];

    // Verify the old password
    if (password_verify($oldPassword, $currentHashedPassword)) {
        // Check that new password is different from old password
        if (!password_verify($newPassword, $currentHashedPassword)) {
            // Hash new password
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update the password
            $updateStmt = $conn->prepare("UPDATE peace SET password = ? WHERE email = ?");
            $updateStmt->bind_param("ss", $newHashedPassword, $username);
            
            if ($updateStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating password.']);
            }
            $updateStmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'New password cannot be the same as the old password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Old password does not match our records.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>
