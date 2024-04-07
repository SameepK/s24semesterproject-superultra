<?php
// Database configuration
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'ugoajaer';
$dbPassword = '50409878';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table if it doesn't exist
$createTableSQL = "CREATE TABLE IF NOT EXISTS debts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creditor VARCHAR(50) NOT NULL,
    balance DECIMAL(10, 2) NOT NULL,
    interestRate DECIMAL(5, 2) NOT NULL,
    minimumPayment DECIMAL(10, 2) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($createTableSQL) === TRUE) {
    // Table created successfully or already exists
} else {
    echo "Error creating table: " . $conn->error;
}

if (isset($_REQUEST['deleteId'])) {
    $deleteId = $conn->real_escape_string($_REQUEST['deleteId']);
    // Use a prepared statement to safely delete the record
    $stmt = $conn->prepare("DELETE FROM debts WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
} 
// Check if the request is POST (to add a new debt)
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $creditor = $conn->real_escape_string($_POST['creditor']);
    $balance = $conn->real_escape_string($_POST['balance']);
    $interestRate = $conn->real_escape_string($_POST['interestRate']);
    $minimumPayment = $conn->real_escape_string($_POST['minimumPayment']);
    
    $sql = "INSERT INTO debts (creditor, balance, interestRate, minimumPayment) VALUES ('$creditor', '$balance', '$interestRate', '$minimumPayment')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Check if the request is GET (to fetch all debts)
else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM debts";
    $result = $conn->query($sql);
    $debts = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $debts[] = $row;
        }
        echo json_encode($debts);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
