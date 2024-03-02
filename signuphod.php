<?php
// Establish database connection
$servername = "oceanus.cse.buffalo.edu";
$username = "ddparris"; // Your database username
$password = "50345153"; // Your database password
$database = "cse442_2024_spring_team_aa_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and ensure proper escaping to prevent SQL Injection
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    // Hash the password for security
    //$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare SQL and bind parameters
    $sql = "INSERT INTO peace (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Handle error here
        echo "Preparation failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        $stmt->bind_param("sss", $username, $email, $password); // Corrected to "sss" since there are three parameters
        if ($stmt->execute()) {
            echo "User registered successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
