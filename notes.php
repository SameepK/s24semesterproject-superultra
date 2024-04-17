/*CREATE DATABASE note_database;
USE note_database;

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);*/


<?php
$host = 'localhost';  // Host name
$dbname = 'note_database';  // Database name
$username = 'your_username';  // Database username
$password = 'your_password';  // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle requests
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

if ($method == 'POST') {
    // Adding a new note
    $content = $_POST['content'];
    if (empty($content)) {
        echo json_encode(['error' => 'Content is empty']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO notes (content) VALUES (?)");
    $stmt->bind_param("s", $content);
    $stmt->execute();
    echo json_encode(['success' => 'Note added']);
} elseif ($method == 'GET') {
    // Fetching all notes
    $result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
    $notes = [];
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    echo json_encode($notes);
}elseif ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];
    if (empty($id)) {
        echo json_encode(['error' => 'ID is required']);
        exit;
    }
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Note removed']);
    } else {
        echo json_encode(['error' => 'Failed to remove note']);
    }
}

$conn->close();
?>
