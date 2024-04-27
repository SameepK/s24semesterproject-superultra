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
        // SQL query to fetch the username associated with the email
        $sql = "SELECT username FROM peace WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];

            // Set cookie using the fetched username
            setcookie("usercookie", $username, time() + 86400, "/");

            // Email setup and sending code remains the same
            $subject = "Logging in";
            $link = "https://www-student.cse.buffalo.edu/CSE442-542/2024-Spring/cse-442aa/home.html";
            $body = "Hello,\n\nPlease click on the following link to log in: $link\n\nIf you did not request to log in please reset your password.";
            $headers = "From: ugo@testing.com\r\n";
            $headers .= "Reply-To: ugo@testing.com\r\n";
            $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

            if (mail($email, $subject, $body, $headers)) {
                echo "Email successfully sent to $email...";
            } else {
                echo "Email sending failed...";
            }
        } else {
            echo "No user found with that email address";
        }
    }
}

// Close the database connection
$conn->close();
?>
