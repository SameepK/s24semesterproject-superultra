<?php

$db = new mysqli('oceanus.cse.buffalo.edu', 'ugoajaer', '50409878', 'cse442_2024_spring_team_aa_db');


$db->query("
    CREATE TABLE IF NOT EXISTS logins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL 
    )
"); 


$username = $_POST['username'] ?? ''; 
$password = $_POST['password'] ?? '';


$db->query("INSERT INTO logins (username, password) VALUES ('$username', '$password')"); 


$to = $username; 
$subject = "Login Notification";
$message = "Your \n Username: $username\n and Password: $password"; 
$headers = "From: ugoajaer@buffalo.edu\r\n"; 

if (mail($to, $subject, $message, $headers)) {
    echo json_encode(["message" => "Login details sent to your email", "success" => true]);
} else { 
    echo json_encode(["message" => "Error sending email", "success" => false]); 
}
?>
