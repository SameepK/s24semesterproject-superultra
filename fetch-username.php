<?php
// Start the session
header('Content-Type: application/json');
session_start();

// Assuming you store the userID in the session when the user logs in
$userID = $_SESSION['userID'];

// Database connection details
$host = 'your_host';
$db   = 'your_database';
$user = 'your_username';
$pass = 'your_password';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Query for the username
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$userID]);
$username = $stmt->fetchColumn();

echo $username;
?>
