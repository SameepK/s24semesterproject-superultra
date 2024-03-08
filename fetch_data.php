<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM peace WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'No account details found']);
}

$stmt->close();
$conn->close();
?>

<!-- php 

session_start();

$servername = "oceanus.cse.buffalo.edu";
$username = "sameepko"; 
$password = "50408723";
$dbname = "cse442_2024_spring_team_aa_db";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT username, Email, password FROM peace WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userData = array(
            'username' => $row['username'],
            'email' => $row['Email'],
            'password' => $row['password']    
        );
        echo json_encode($userData);
    } else {
        echo "No user found with that username";
    }   

    $stmt->close();
} else {
    echo "Username not set in session";
}

$conn->close();

?> -->
