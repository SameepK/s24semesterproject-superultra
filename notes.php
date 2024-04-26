/*CREATE DATABASE note_database;
USE note_database;

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);*/


<?php
session_start();

$host = 'oceanus.cse.buffalo.edu';  // Host name
$dbname = 'cse442_2024_spring_team_aa_db';  // Database name
$username = 'ddparris';  // Database username
$password = '50345153';  // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get user ID from username
function getUserID($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    }
    return null;
}

// Check if usercookie is present and set user_id in session
if (!isset($_SESSION['user_id']) && isset($_COOKIE['usercookie'])) {
    $username = $_COOKIE['usercookie'];
    $user_id = getUserID($conn, $username);
    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
    } else {
        // Handle error - user not found
        echo json_encode(['error' => 'User not found']);
        exit;
    }
}

// Handle requests
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

if ($method == 'POST') {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id']; // Retrieve user id from session

    if (empty($content)) {
        echo json_encode(['error' => 'Content is empty']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO notes (content, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $content, $user_id);
    $stmt->execute();
    echo json_encode(['success' => 'Note added']);
} elseif ($method == 'GET') {
    $user_id = $_SESSION['user_id']; // Retrieve user id from session
    $stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notes = [];
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    echo json_encode($notes);
} elseif ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];
    $user_id = $_SESSION['user_id']; // Retrieve user id from session

    if (empty($id)) {
        echo json_encode(['error' => 'ID is required']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Note removed']);
    } else {
        echo json_encode(['error' => 'Failed to remove note']);
    }
}

$conn->close();
?>
