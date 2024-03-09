<?php
// Your database connection details
$dbServer = 'oceanus.cse.buffalo.edu:3306';
$dbUsername = 'ugoajaer';
$dbPassword = '50409878';
$dbName = 'cse442_2024_spring_team_aa_db';

// Create database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email address from the form
    $email = $_POST['username']; // Adjust accordingly if your input name differs

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        // Your email subject
        $subject = "Reset Your Password";

        // Your email body content
        $link = "https://www-student.cse.buffalo.edu/CSE442-542/2024-Spring/cse-442aa/ugo/";
        $body = "Hello,\n\nPlease click on the following link to reset your password: $link\n\nIf you did not request a password reset, please ignore this email.";

        // Headers
        $headers = "From: ugo@testing.com\r\n";
        $headers .= "Reply-To: ugo@testing.com\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

        // Send the email
        if (mail($email, $subject, $body, $headers)) {
            echo "Email successfully sent to $email...";
        } else {
            echo "Email sending failed...";
        }
    }
}

// Close the database connection
$conn->close();
?>
