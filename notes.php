<?php
session_start();

$host = 'oceanus.cse.buffalo.edu';  // Host name
$dbname = 'cse442_2024_spring_team_aa_db';  // Database name
$dbusername = 'ddparris';  // Database username
$password = '50345153';  // Database password

// Create connection
$conn = new mysqli($host, $dbusername, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if username is stored in the cookie and set it to the session if necessary
if (!isset($_SESSION['username']) && isset($_COOKIE['usercookie'])) {
    $_SESSION['username'] = $_COOKIE['usercookie'];
}

// Handle requests
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

switch ($method) {
    case 'POST':
        // Adding a new note
        if (!isset($_SESSION['username'])) {
            echo json_encode(['error' => 'User not logged in']);
            exit;
        }
        $username = $_SESSION['username'];
        $content = $_POST['content'];

        if (empty($content)) {
            echo json_encode(['error' => 'Content is empty']);
            exit;
        }
        $stmt = $conn->prepare("INSERT INTO notes (content, username) VALUES (?, ?)");
        $stmt->bind_param("ss", $content, $username);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Note added']);
        } else {
            echo json_encode(['error' => 'Failed to add note', 'db_error' => $stmt->error]);
        }
        break;

    case 'GET':
        // Fetching all notes for the logged-in user
        if (!isset($_SESSION['username'])) {
            echo json_encode([]);
            exit;
        }
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT * FROM notes WHERE username = ? ORDER BY created_at DESC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $notes = [];
        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
        echo json_encode($notes);
        break;

    case 'DELETE':
        // Deleting a note
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = $_DELETE['id'];
        if (!isset($_SESSION['username'])) {
            echo json_encode(['error' => 'User not logged in']);
            exit;
        }
        $username = $_SESSION['username'];

        if (empty($id)) {
            echo json_encode(['error' => 'ID is required']);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND username = ?");
        $stmt->bind_param("is", $id, $username);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Note removed']);
        } else {
            echo json_encode(['error' => 'Failed to remove note', 'db_error' => $stmt->error]);
        }
        break;
}

$conn->close();
?>
