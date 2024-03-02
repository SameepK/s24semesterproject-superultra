<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Database configuration
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'ugoajaer';
$dbPassword = '50409878';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Retrieve and decode the JSON data from the request
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'];
$oldPassword = $input['oldPassword'];
$newPassword = $input['newPassword'];

// Validate input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($username) && !empty($oldPassword) && !empty($newPassword)) {
        // Prepare a select statement to fetch the user's current hashed password
        $stmt = $conn->prepare("SELECT password FROM peace WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentHashedPassword = $row['password'];

            // Verify the old password
            if (True) /*NOTE must check that oldPassword and currenHashedPassword correspond*/ {
                // Update the password
                $newHashedPassword = $newPassword;
                $updateStmt = $conn->prepare("UPDATE peace SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $newHashedPassword, $username);
                if($updateStmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Password updated successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error updating password."]);
                }
                $updateStmt->close();
            } else {
                echo json_encode([
                    "success" => false, 
                    "message" => "Invalid old password. Username: " . $username . ", Old Password: " . $oldPassword . ", hashp: " .$currentHashedPassword
                ]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Invalid username."]);
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Missing username, old password, or new password."]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close connection
$conn->close();
?>
