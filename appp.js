document.getElementById('ResetPassword').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Assuming your username field is within a form and its id is 'username'
    var email = document.getElementById('username').value;
    
    // Data to be sent to the server
    var formData = new FormData();
    formData.append('username', email);

    // Fetch API to send the form data to the PHP script and handle the response
    fetch('sendEmail.php', {
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
});



