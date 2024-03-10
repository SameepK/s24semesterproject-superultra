<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// Establish database connection
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
    // Retrieve form data and ensure proper escaping to prevent SQL Injection
    
    $input = json_decode(file_get_contents('php://input'), true);

    // Extract data from the decoded JSON
    $form_username = $conn->real_escape_string($input['username']);
    $email = $conn->real_escape_string($input['email']);
    $password = $input['password']; // Assuming you'll hash this before storing
    $confirm_password = $input['confirmPassword']; // Used for validation, not stored
    
    // Check if password and confirm password are the same
    if ($password !== $confirm_password) {
        $response['message'] = "Passwords do not match.";
        echo json_encode($response);
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format";
        echo json_encode($response);
        exit();
        
    }

    // Check for password strength
    $passwordRequirements = '/(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}/';
    if (!preg_match($passwordRequirements, $password)) {
        $response['message'] = "Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.";
        echo json_encode($response);
        exit();
    }

    // Hash the password for security
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL and bind parameters
    $sql = "INSERT INTO peace (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $response['message'] = "Preparation failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $form_username, $email, $newHashedPassword); // Use the hashed password
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "User registered successfully.";
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();

// Encode and return the response as JSON
echo json_encode($response);
?>

