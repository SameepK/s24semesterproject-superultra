<?php
header('Content-Type: application/json'); // Ensure JSON response

$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'ugoajaer';
$dbPassword = '50409878';
$dbName = 'cse442_2024_spring_team_aa_db';

$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

$table = "CREATE TABLE IF NOT EXISTS logins2 (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if (!$conn->query($table)) {
    echo json_encode(['success' => false, 'message' => "Error creating table: " . $conn->error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assuming you want to hash the password as well for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO peace (username, password) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'New record created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register user']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
