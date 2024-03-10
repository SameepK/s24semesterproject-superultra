document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Extract username and password
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Construct URL with query parameters
    var url = `checkcorrespondence.php?username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`;

    // Send data to the server via GET
    fetch(url, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            var email = document.getElementById('username').value;
    
            // Data to be sent to the server
            var formData = new FormData();
            formData.append('username', email);
        
            // Fetch API to send the form data to the PHP script and handle the response
            fetch('sendEmail2FA.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Convert the response to text
            .then(data => {
                // Display the PHP script's response
                alert(data); // Or use any other method to display the message
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('Login Failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
