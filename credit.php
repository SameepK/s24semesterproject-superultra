<?php
// Replace with your actual database credentials
$host = 'localhost';
$db   = 'creditDB';
$user = 'yourUsername';
$pass = 'yourPassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score'])) {
    $score = $_POST['score'];
    if (filter_var($score, FILTER_VALIDATE_INT) === false || $score < 300 || $score > 850) {
        http_response_code(400);
        echo "Invalid score provided.";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO scores (score) VALUES (:score)");
    $stmt->execute(['score' => $score]);

    echo "Score saved successfully.";
} else {
    http_response_code(405);
    echo "Method not allowed or no score provided.";
}
?>
