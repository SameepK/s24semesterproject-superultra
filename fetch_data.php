<?php 

session_start();

$servername = "localhost";
$username = "username"; 
$password = "password";
$dbname = "account_information";


$db = new mysqli('oceanus.cse.buffalo.edu', 'sameepko', '50408723', 'cse442_2024_spring_team_aa_db');

if ($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

$username = $_SESSION['username'];

$query = "SELECT username, email FROM users WHERE username='$username'";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userData = array(
        'username' => $row['username'],
        'email' => $row['email'], 
        'name' => $rom['name'], 
        'account number' => $row ['number']    
    );
    echo json_encode($userData);
} else {
    header("Connection Failed");
}

$stmt->close();
$db->close();
?>
