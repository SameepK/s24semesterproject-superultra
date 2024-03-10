<?php
// Connect to MySQL database
$servername = 'oceanus.cse.buffalo.edu:3306';
$username = 'aidenfer';
$password = '50454707';
$dbname = 'cse442_2024_spring_team_aa_db';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the current user's username from the database
// Replace 'current_user_id' with the actual method to retrieve the current user's ID
$current_user_id = $_SESSION['user_id']; // Assuming you're using sessions for authentication
$sql = "SELECT username FROM users WHERE id = $current_user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output username in JSON format
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo "0 results";
}
$conn->close();
?>
