<?php
// Establish database connection
header('Content-Type: application/json');

$servername = "oceanus.cse.buffalo.edu";
$username = "ddparris"; // Your database username
$password = "50345153"; // Your database password
$database = "cse442_2024_spring_team_aa_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Initialize an array to hold the response
$response = ['success' => false, 'message' => ''];

// Check connection
if ($conn->connect_error) {
    $response['message'] = "Connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password are the same
    if ($password !== $confirm_password) {
        $response['message'] = "Passwords do not match.";
    } else {
        // Password requirements
        $passwordRequirements = '/(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}/';
        if (!preg_match($passwordRequirements, $password)) {
            $response['message'] = "Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.";
        } else {
            // Insert user into database
            $sql = "INSERT INTO peace (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $response['message'] = "Preparation failed: (" . $conn->errno . ") " . $conn->error;
            } else {
                $stmt->bind_param("sss", $form_username, $email, $password); // Assuming you're hashing password before storing
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "User registered successfully.";
                } else {
                    $response['message'] = "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
    echo json_encode($response);
}

$conn->close();
?>
