<?php
// Establish database connection (replace placeholders with your actual database credentials)
$servername = 'oceanus.cse.buffalo.edu';
$username = "ddparris";
$password = "50345153";
$database = 'cse442_2024_spring_team_aa_db';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate random code
$code = mt_rand(100000, 999999);

// Store code in database
$sql = "INSERT INTO verification_codes (email, code) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$email = $_POST['email']; // Assuming you're getting the user's email through a form
$stmt->bind_param("ss", $email, $code);
$stmt->execute();

// Send email
$to = $email;
$subject = "Your verification code";
$message = "Your verification code is: " . $code;
$headers = "From: your_email@example.com"; // Replace with your email
mail($to, $subject, $message, $headers);

echo "Verification code sent to your email.";
$stmt->close();
$conn->close();
?>
