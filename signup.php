<?php
// Establish database connection (replace placeholders with your actual database credentials)
$servername = "oceanus.cse.buffalo.edu";
$username = "ddparris";
$password = "50345153";
$database = "cse442_2024_spring_team_aa_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    // Insert user data into database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password);
    $stmt->execute();

    // Check if data is inserted successfully
    if ($stmt->affected_rows > 0) {
        echo "User registered successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
