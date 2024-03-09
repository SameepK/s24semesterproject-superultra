<?php
require 'db.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); // Ensure JSON response

// Database connection details
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'ugoajaer';
$dbPassword = '50409878';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Create table if it doesn't exist
$table = "CREATE TABLE IF NOT EXISTS peace(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if (!$conn->query($table)) {
    echo json_encode(['success' => false, 'message' => "Error creating table: " . $conn->error]);
    exit;
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get JSON input and decode it
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'];
    $password = $input['password'];

    // Hash the password for security
    $hashedPassword = $password;

    // Insert into the correct table 'logins2', not 'peace'
    $sql = "INSERT INTO peace (username, password) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'New record created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register user']);
    }

    // Close statement
    //$stmt->close();
    // Handle non-POST requests
    echo json_encode(['success' => false, 'message' => 'Invalid request']);

    $sql = "SELECT email FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        // Assuming you've verified the user's password and are ready to send the 2FA code
        $code = rand(100000, 999999); // Simple 6-digit code

        // Email details
        $to = $user['email']; // User's email address from the database
        $subject = 'Your 2FA Code';
        $message = "Your 2FA code is: $code";
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Send the email
        mail($to, $subject, $message, $headers);

        // Redirect or inform the user accordingly
        echo "2FA code sent to your email.";
    } else {
        // Handle case where username does not exist
        echo "Invalid username.";
    }
    $sql = "INSERT INTO two_factor_auth (user_id, code) VALUES (:user_id, :code) ON DUPLICATE KEY UPDATE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    'user_id' => $username, 
    'code' => $code
]);
}
$conn->close();
?>


