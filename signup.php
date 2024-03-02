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
    //$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Ensure password is hashed

    // Prepare SQL and bind parameters
    $sql = "INSERT INTO peace (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Preparation failed, terminate with an error message
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    } else {
        $stmt->bind_param("sss", $username, $email, $password); // Bind parameters
        if ($stmt->execute()) {
            // Redirect to login page after successful account creation
            header('Location: send_email.php'); // Adjust to the correct path of your login page
            exit(); // Prevent further script execution after redirection
        } else {
            // Handle execution failure
            die("Error: " . $stmt->error);
        }
        $stmt->close();
    }
}

$conn->close();
?>
