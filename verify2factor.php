<?php
// Start the session to access session variables
session_start();

// Check if there's a user email and a 2FA code in the session and POST data, respectively
if (!isset($_SESSION['user_email'])) {
    die("User email not found. Please log in again.");
}

if (!isset($_POST['2FA'])) {
    die("2FA code not provided.");
}

// Retrieve the user email from the session
$email = $_SESSION['user_email'];
// Retrieve the submitted 2FA code from POST data
$userSubmittedCode = $_POST['2FA'];

// Database connection parameters
$servername = 'oceanus.cse.buffalo.edu';
$username = "ddparris";
$password = "50345153";
$database = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch the latest 2FA code sent to the user's email
$sql = "SELECT code FROM verification_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1";

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if a code exists for the given email
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedCode = $row['code'];
    
    // Compare the submitted code with the stored code
    if ($userSubmittedCode == $storedCode) {
        echo "Verification successful.";
        // Here, you can proceed with the login process, such as setting logged-in user session variables
    } else {
        echo "Verification failed. Incorrect code.";
    }
} else {
    echo "No verification code found. Please request a new code.";
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
