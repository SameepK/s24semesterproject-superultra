<?php
// Database connection details
$servername = 'oceanus.cse.buffalo.edu';
$username = "ddparris";
$password = "50345153";
$database = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a user's email through POST request
$email = $_POST['email'];

// Generate random code
$code = mt_rand(100000, 999999);

// Store code in database with email
$sql = "INSERT INTO verification_codes (email, code) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $code);
$stmt->execute();

// Send email
$to = $email;
$subject = "Your 2FA Code";
$message = "Your verification code is: " . $code;
$headers = "From: your_email@example.com"; // Replace with your actual email
mail($to, $subject, $message, $headers);

echo "2FA code sent to your email.";

$stmt->close();
$conn->close();
?>
